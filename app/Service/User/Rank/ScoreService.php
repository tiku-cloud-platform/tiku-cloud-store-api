<?php
declare(strict_types = 1);

namespace App\Service\User\Rank;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Repository\User\Rank\ScoreRepository;
use App\Service\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 积分排行
 *
 * Class ScoreService
 * @package App\Service\User\Rank
 */
class ScoreService implements UserServiceInterface
{
    /**
     * @Inject()
     * @var ScoreRepository
     */
    protected $scoreRepository;

    /**
     * 格式化查询条件
     *
     * @param array $requestParams 请求参数
     * @return mixed 组装的查询条件
     */
    public static function searchWhere(array $requestParams)
    {
        return function () {
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
        return $this->scoreRepository->repositorySelect(self::searchWhere((array)$requestParams),
            (int)$requestParams['number'] ?? 10);
    }

    /**
     * 创建数据
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        // TODO: Implement serviceCreate() method.
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
        // TODO: Implement serviceFind() method.
    }

    /**
     * 积分排行
     *
     * @param array $requestParams
     * @return array
     */
    public function serviceGroup(array $requestParams): array
    {
        $cacheInfo = RedisClient::get((string)CacheKey::WECHAT_RANK_SCORE, (string)'today');
        if (empty($cacheInfo)) {
            $cacheInfo  = $this->scoreRepository->repositoryGroup(self::searchWhere((array)$requestParams),
                (int)$requestParams['size'] ?? 15);
            $expireTime = strtotime(date('Y-m-d 23:59:59')) - time();
            RedisClient::create((string)CacheKey::WECHAT_RANK_SCORE, (string)'today', (array)$cacheInfo, (int)$expireTime);
        }

        return $cacheInfo;
    }

}