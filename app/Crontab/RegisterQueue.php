<?php
declare(strict_types = 1);

namespace App\Crontab;

use App\Mapping\RedisClient;
use App\Mapping\UUID;
use App\Model\Shell\StorePlatformScore;
use App\Model\Shell\StorePlatformUser;
use App\Model\Shell\StorePlatformUserGroup;
use App\Repository\User\User\ScoreHistoryRepository;
use Hyperf\Crontab\Annotation\Crontab;
use Hyperf\Di\Annotation\Inject;

/**
 * 微信小程序用户注册队列
 * Class RegisterQueue
 * @package App\Crontab
 * @Crontab(name="register_queue", rule="*\/1 * * *  *", callback="execute", memo="微信小程序用户注册队列")
 */
class RegisterQueue
{
    /**
     * @Inject()
     * @var ScoreHistoryRepository
     */
    protected $scoreHistoryRepository;

    public function execute()
    {
        $registerUser = (new RedisClient())->redisClient->rPop("register_queue");
        var_dump("获取Redis数据", $registerUser);
        if ($registerUser) {
            try {
                $registerUser = json_decode($registerUser, true);
                // 1. 查询对应的商户平台是否存在用户注册赠送积分
                $scoreConfig = (new StorePlatformScore())->getScoreConfig((array)[["key", "=", "wechat_register"], ["store_uuid", "=", $registerUser["store_uuid"]]]);
                $groupConfig = (new StorePlatformUserGroup())->getGroup((array)[["store_uuid", "=", $registerUser["store_uuid"]]]);
                var_dump("积分配置", $scoreConfig);
                if (!empty($scoreConfig)) {
                    $requestParams['title']       = $scoreConfig['title'];
                    $requestParams['score_key']   = $scoreConfig['key'];
                    $requestParams["client_type"] = $registerUser["client_type"];
                    $requestParams['score']       = $scoreConfig['score'];
                    $requestParams['score_key']   = $scoreConfig['key'];
                    $requestParams["type"]        = 1;
                    $requestParams['uuid']        = UUID::getUUID();
                    $requestParams['store_uuid']  = $registerUser["store_uuid"];
                    $requestParams['user_uuid']   = $registerUser["user_uuid"];
                    var_dump("插入的数据是", $requestParams);
                    if (!$this->scoreHistoryRepository->repositoryCreate((array)$requestParams)) {
                        (new RedisClient())->redisClient->rPush("register_queue", json_encode($registerUser));
                    } else {
                        // 更新用户分组信息
                        (new StorePlatformUser())::query()->where([["uuid", "=", $registerUser["user_uuid"]]])->update(["store_platform_user_group_uuid" => $groupConfig["uuid"]]);
                        var_dump("积分创建成功");
                    }
                } else {
                    var_dump("未配置积分");
                }
            } catch (\Throwable $throwable) {
                var_dump($throwable->getMessage());
                (new RedisClient())->redisClient->lPush("register_queue", json_encode($registerUser, JSON_UNESCAPED_UNICODE));
            }
        } else {
            var_dump("数据获取失败");
        }
    }
}