<?php
declare(strict_types = 1);

namespace App\Service\User\User;


use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\User\User\SignHistoryRepository;
use App\Service\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 签到历史
 *
 * Class SignHistoryService
 * @package App\Service\User\User
 */
class SignHistoryService implements UserServiceInterface
{
    /**
     * @Inject()
     * @var SignHistoryRepository
     */
    protected $signHistory;

    public function __construct()
    {
    }

    /**
     * 格式化查询条件
     *
     * @param array $requestParams 请求参数
     * @return mixed 组装的查询条件
     */
    public static function searchWhere(array $requestParams)
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($user_uuid)) {
                $query->where('user_uuid', '=', $user_uuid);
            }
            if (!empty($sign_date)) {
                $query->where('sign_date', '=', $sign_date);
            }
        };
    }

    /**
     * 查询数据
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    /**
     * 创建数据
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        $userInfo                    = UserInfo::getWeChatUserInfo();
        $requestParams['store_uuid'] = $userInfo['store_uuid'];
        $requestParams['user_uuid']  = $userInfo['user_uuid'];
        $requestParams['uuid']       = UUID::getUUID();
        $requestParams['sign_date']  = date('Y-m-d');

        $yesterday     = date('Y-m-d', strtotime('-1 day'));
        $yesterdayInfo = $this->serviceFind((array)['user_uuid' => $userInfo['user_uuid'], 'sign_date' => $yesterday]);
        $scoreConfig   = (new ScoreConfigService())->serviceFind((array)['key' => 'wechat_day_sign']);

        return $this->signHistory->repositoryCreate((array)[
            'history'       => $requestParams,// 签到记录
            'yesterdayInfo' => $yesterdayInfo,// 昨日签到记录
            'score'         => empty($scoreConfig) ? [] : [
                'score'      => $scoreConfig['score'],
                'title'      => $scoreConfig['title'],
                'user_uuid'  => $userInfo['user_uuid'],
                'store_uuid' => $userInfo['store_uuid'],
                'type'       => 1,
                'uuid'       => UUID::getUUID(),
                'score_key'  => 'wechat_day_sign'
            ], // 签到积分配置
        ]);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        // TODO: Implement serviceUpdate() method.
    }

    /**
     * 删除数据
     *
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        if (!empty($requestParams['sign_date'])) {
            $result = (new RedisClient())->redisClient->getBit(CacheKey::USER_SING_DAY . $requestParams['user_uuid'],
                (int)str_replace('-', '', $requestParams['sign_date']));
            if ($result == 1) return ['sign_date' => $result];
        }

        return $this->signHistory->repositoryFind(self::searchWhere((array)$requestParams));
    }
}