<?php
declare(strict_types=1);

namespace App\Crontab;

use App\Mapping\RedisClient;
use App\Mapping\UUID;
use App\Model\Shell\StoreArticle;
use App\Model\Shell\StoreArticleReadClick;
use Hyperf\Crontab\Annotation\Crontab;

/**
 * 用户签到处理
 * Class ArticleQueue
 * @package App\Crontab
 * @Crontab(name="article_queue", rule="*\/1 * * *  *", callback="execute", memo="文章也读或点赞")
 */
class ArticleQueue
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
		$queueName     = "article:read:queue";
		$redisPipeLine->lRange($queueName, 0, 10);
		$redisPipeLine->lTrim($queueName, 11, -1);

		$execResult = $redisPipeLine->exec();
		try {
			if (isset($execResult) && $execResult[1] === true) {
				$cacheInfo = $execResult[0];
				if (!empty($cacheInfo)) {
					$articleModel = new StoreArticle();
					foreach ($cacheInfo as $value) {
						$arr = explode(",", $value);
						var_dump($arr);
						if (!empty($arr) && !empty(trim($arr[3]))) {
							$historyArray[] = [
								"uuid"         => UUID::getUUID(),
								"store_uuid"   => $arr[1],
								"user_uuid"    => $arr[3],
								"article_uuid" => $arr[0],
								"type"         => $arr[2],
							];
							(new StoreArticleReadClick())->batchInsert((array)$historyArray);
						}
						if ($arr[2] == 1) {
							$articleModel->batchUpdateColumn((array)$arr[0], (string)"click_number");
						} elseif ($arr[2] == 2) {
							$articleModel->batchUpdateColumn((array)$arr[0], (string)"read_number");
						}
					}
				}
			}
		} catch (\Throwable $throwable) {
			var_dump($throwable->getFile(), $throwable->getMessage());
		}
	}
}