<?php
declare(strict_types = 1);

namespace App\Crontab;

use App\Mapping\RedisClient;
use App\Mapping\UUID;
use App\Model\Shell\StoreChannel;
use App\Model\Shell\StoreMiNiWeChatUser;
use App\Model\Shell\StorePlatformScore;
use App\Model\Shell\StorePlatformUser;
use App\Model\Shell\StorePlatformUserGroup;
use App\Model\Shell\StoreUserScoreCollection;
use App\Model\Shell\StoreUserScoreHistory;
use Hyperf\Crontab\Annotation\Crontab;

/**
 * 微信小程序用户注册队列
 * Class RegisterQueue
 * @package App\Crontab
 * @Crontab(name="register_queue", rule="*\/1 * * *  *", callback="execute", memo="微信小程序用户注册队列")
 */
class RegisterQueue
{
    public function execute()
    {
        $redisClient              = new RedisClient();
        $platformUser             = new StorePlatformUser();
        $userScoreCollectionModel = new StoreUserScoreCollection();
        $weChatUserModel          = new StoreMiNiWeChatUser();
        $storeChannelModel        = new StoreChannel();
        $scoreHistoryModel        = new StoreUserScoreHistory();
        $scoreConfigModel         = new StorePlatformScore();
        $userGroupModel           = new StorePlatformUserGroup();

        $registerUser = $redisClient->redisClient->rPop("register_queue");
        if ($registerUser) {
            try {
                $registerUser = json_decode($registerUser, true);

                //  查询对应的商户平台是否存在用户注册赠送积分
                $scoreConfig = $scoreConfigModel->getScoreConfig((array)[["key", "=", $registerUser["register_type"]], ["store_uuid", "=", $registerUser["store_uuid"]]]);
                // 查询对应的商户平台是否存在用户分组信息
                $groupConfig = $userGroupModel->getGroup((array)[["store_uuid", "=", $registerUser["store_uuid"]]]);
                if (!empty($scoreConfig)) {
                    $requestParams['title']       = $scoreConfig['title'];
                    $requestParams['score_key']   = $scoreConfig['key'];
                    $requestParams["client_type"] = $registerUser["client_type"];
                    $requestParams['score']       = $scoreConfig['score'];
                    $requestParams["type"]        = 1;
                    $requestParams['uuid']        = UUID::getUUID();
                    $requestParams['store_uuid']  = $registerUser["store_uuid"];
                    $requestParams['user_uuid']   = $registerUser["user_uuid"];
                    if (!$scoreHistoryModel::query()->create($requestParams)) {
                        // 创建失败之后，重新将注册用户的信息放回Redis队列中
                        $redisClient->redisClient->rPush("register_queue", json_encode($registerUser));
                    } else {
                        // 更新用户的分组信息
                        $platformUser::query()->where([["uuid", "=", $registerUser["user_uuid"]]])
                            ->update([
                                "store_platform_user_group_uuid" => $groupConfig["uuid"]
                            ]);
                        // 先查询用户是否存在积分汇总的记录，不存在则创建，存在则更新
                        $bean = $userScoreCollectionModel::query()->where([
                            ["user_uuid", "=", $registerUser["user_uuid"]],
                            ["store_uuid", "=", $registerUser["store_uuid"]],
                        ])->first(["id"]);
                        if (empty($bean)) {
                            $userScoreCollectionModel::query()->create([
                                "uuid"       => UUID::getUUID(),
                                "user_uuid"  => $registerUser["user_uuid"],
                                "score"      => $scoreConfig['score'],
                                "store_uuid" => $registerUser["store_uuid"],
                            ]);
                        } else {
                            $userScoreCollectionModel::query()->where([
                                ["user_uuid", "=", $registerUser["user_uuid"]],
                                ["store_uuid", "=", $registerUser["store_uuid"]],
                            ])->increment("score", $scoreConfig["score"]);
                        }
                        // 更新用户注册渠道
                        if (!empty($registerUser["channel_id"])) {
                            $bean = $storeChannelModel::query()->where([["id", "=", $registerUser["channel_id"]]])->first(["uuid"]);
                            if (!empty($bean)) {
                                // 1微信小程序2微信公众号3iOS客户端4Android客户端5PC端
                                if ($registerUser["client_type"] == 1) {
                                    $weChatUserModel::query()->where([["user_uuid", "=", $registerUser["user_uuid"]]])
                                        ->update(["channel_uuid" => $bean->uuid]);
                                }
                                // 更新用户注册渠道
                                $platformUser::query()->where([["uuid", "=", $registerUser["user_uuid"]]])
                                    ->update(["channel_uuid" => $bean->uuid]);
                            }
                        }
                    }
                }
            } catch (\Throwable $throwable) {
                $redisClient->redisClient->lPush("register_queue", json_encode($registerUser, JSON_UNESCAPED_UNICODE));
            }
        } else {
            var_dump("暂无注册用户");
        }
    }
}