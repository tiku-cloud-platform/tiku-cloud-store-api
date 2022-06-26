<?php
declare(strict_types=1);

namespace App\Crontab;

use App\Mapping\RedisClient;
use App\Mapping\UUID;
use App\Model\Shell\StoreMiNiWeChatUser;
use App\Model\Shell\StoreUserScoreCollection;
use App\Model\Shell\StoreUserScoreHistory;
use App\Model\Shell\StoreUserSignCollection;
use App\Model\Shell\StoreUserSignHistory;
use Hyperf\Crontab\Annotation\Crontab;
use Hyperf\DbConnection\Db;

/**
 * 用户签到处理(替换为定时器触发)
 * Class SignQueue
 * @package App\Crontab
 * @Crontab(name="sign_queue", rule="*\/1 * * *  *", callback="execute", memo="用户签到处理")
 */
class SignQueue
{
	/**
	 * 用户签到队列处理
	 * 1. 签到汇总表处理
	 * 2. 签到历史记录处理
	 * 3. 积分汇总处理
	 * 4. 积分历史处理
	 */
	public function execute()
	{
		$redis         = (new RedisClient())->redisClient;
		$redisPipeLine = $redis->pipeline();
		/** @var string $queueName 签到队列名称 */
		$queueName = "user_sign:queue";
		$redisPipeLine->lRange($queueName, 0, 10);
		$redisPipeLine->lTrim($queueName, 11, -1);
		$userModel  = new StoreMiNiWeChatUser();
		$execResult = $redisPipeLine->exec();
		if (isset($execResult) && $execResult[1] === true) {
			$signCacheInfo = $execResult[0];
			if (!empty($signCacheInfo)) {
				Db::beginTransaction();
				$successNumber = 0;
				foreach ($signCacheInfo as $value) {// 后期优化，通过批量插入方式操作数据库。并且将签到队列中的积分运算单独作为一个队列，当做系统全局积分队列。
					try {
						$cacheInfo = json_decode($value, true);
						$result1   = $this->signCollection((array)$cacheInfo);
						$result2   = $this->signHistory((array)$cacheInfo);
						$result3   = $this->scoreCollection((array)$cacheInfo);
						$result4   = $this->scoreHistory((array)$cacheInfo);
						if ($result1 && $result2 && $result3 && $result4) {
							// 更新签到缓存
							$userInfo           = $userModel::query()->where([
								["user_uuid", "=", $cacheInfo["user_uuid"]]
							])->first(["login_token"])->toArray();
							$loginCache         = $redis->get("mini:user_login:" . $userInfo["login_token"]);
							$loginCache         = json_decode($loginCache, true);
							$loginCache["sign"] = $cacheInfo["sing_number"];
							$redis->set("mini:user_login:" . $userInfo["login_token"], json_encode($loginCache));
							++$successNumber;
						}
					} catch (\Throwable $throwable) {
						preg_match("/Duplicate entry/", $throwable->getMessage(), $result);
						if (!empty($result)) {
							++$successNumber;
						}
					}
				}
				if ($successNumber == count($signCacheInfo)) {
					Db::commit();

				} else {
					Db::rollBack();
					// 返回队列
					$redis->lPush("user_sign:queue", ...$signCacheInfo);
				}
			}
		}
	}

	/**
	 * 处理签到汇总
	 * @param array $cacheInfo 签到缓存信息
	 * @return bool
	 */
	private function signCollection(array $cacheInfo): bool
	{
		$signCollectionModel = new StoreUserSignCollection();
		$bean                = $signCollectionModel::query()->where([
			"user_uuid"  => $cacheInfo["user_uuid"],
			"store_uuid" => $cacheInfo["store_uuid"],
		])->first(["id", "sign_number"]);
		if (!empty($bean)) {
			// 查询前一天是否存在签到记录
			$history    = (new StoreUserSignHistory())::query()->where([
				"user_uuid"  => $cacheInfo["user_uuid"],
				"store_uuid" => $cacheInfo["store_uuid"],
				"sign_date"  => date("Y-m-d"),
			])->first(["id"]);
			$signNumber = 1;
			if (!empty($history)) {
				$signNumber += $bean->toArray()["sign_number"];
			}
			$result = $signCollectionModel::query()->where([
				"user_uuid"  => $cacheInfo["user_uuid"],
				"store_uuid" => $cacheInfo["store_uuid"],
			])->update(["sign_number" => $signNumber]);
		} else {
			$result = $signCollectionModel::query()->create([
				"uuid"        => UUID::getUUID(),
				"user_uuid"   => $cacheInfo["user_uuid"],
				"sign_number" => 1,
				"is_show"     => 1,
				"store_uuid"  => $cacheInfo["store_uuid"],
			]);
		}
		return !empty($result);
	}

	/**
	 * 处理签到历史记录
	 * @param array $cacheInfo
	 * @return bool
	 */
	private function signHistory(array $cacheInfo): bool
	{
		$signHistoryCollectionModel = new StoreUserSignHistory();
		$bean                       = $signHistoryCollectionModel::query()->create([
			"uuid"       => UUID::getUUID(),
			"user_uuid"  => $cacheInfo["user_uuid"],
			"sign_date"  => $cacheInfo["sign_date"],
			"is_show"    => 1,
			"store_uuid" => $cacheInfo["store_uuid"],
		]);
		return !empty($bean);
	}

	/**
	 * 处理积分汇总
	 * @param array $cacheInfo
	 * @return bool
	 */
	private function scoreCollection(array $cacheInfo): bool
	{
		if (empty($cacheInfo["score_config"]["key"])) {// 生产者没有把签到积分配置添加到队列中或者系统没有配置签到赠送积分
			return true;
		}
		$scoreCollectionModel = new StoreUserScoreCollection();
		$bean                 = $scoreCollectionModel::query()->where([
			["user_uuid", "=", $cacheInfo["user_uuid"]],
			["store_uuid", "=", $cacheInfo["score_config"]["store_uuid"]]
		])->first(["id"]);

		if (!empty($bean)) {// 更新
			$result = $scoreCollectionModel::query()->where([
				["user_uuid", "=", $cacheInfo["user_uuid"]],
				["store_uuid", "=", $cacheInfo["score_config"]["store_uuid"]]
			])->increment("score", $cacheInfo["score_config"]["score"]);
			return !empty($result);
		} else {// 创建
			$bean = $scoreCollectionModel::query()->create([
				"uuid"       => UUID::getUUID(),
				"user_uuid"  => $cacheInfo["user_uuid"],
				"score"      => $cacheInfo["score_config"]["score"],
				"store_uuid" => $cacheInfo["score_config"]["store_uuid"],
			]);
			return !empty($bean);
		}
	}

	/**
	 * 处理积分历史
	 * @param array $cacheInfo
	 * @return bool
	 */
	private function scoreHistory(array $cacheInfo): bool
	{
		if (empty($cacheInfo["score_config"]["key"])) {// 生产者没有把签到积分配置添加到队列中或者系统没有配置签到赠送积分
			return true;
		}

		$scoreHistoryCollectionModel = new StoreUserScoreHistory();
		$result                      = $scoreHistoryCollectionModel::query()->create([
			'uuid'        => UUID::getUUID(),
			'type'        => 1,
			'title'       => $cacheInfo["score_config"]["title"],
			'score'       => $cacheInfo["score_config"]["score"],
			'user_uuid'   => $cacheInfo["user_uuid"],
			'score_key'   => $cacheInfo["score_config"]["key"],
			'store_uuid'  => $cacheInfo["score_config"]["store_uuid"],
			"is_show"     => 1,
			"client_type" => $cacheInfo["client_type"]
		]);

		return !empty($result);
	}
}