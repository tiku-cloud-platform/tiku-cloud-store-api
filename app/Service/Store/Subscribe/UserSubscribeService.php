<?php
declare(strict_types = 1);

namespace App\Service\Store\Subscribe;

use App\Repository\Store\Subscribe\UserSubscribeRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 微信用户订阅消息
 *
 * Class UserSubscribeService
 * Author 卡二条
 * Email 2665274677@qq.com
 * Date 2021/9/20
 * @package App\Service\Store\Subscribe
 */
class UserSubscribeService implements StoreServiceInterface
{
    /**
     * @Inject()）
     * @var UserSubscribeRepository
     */
    protected $userSubscribeRepository;

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
            if (!empty($user_id)) {
                $query->where('user_uuid', '=', $user_id);
            }
            if (!empty($config_uuid)) {
                $query->where('template_config_uuid', '=', $config_uuid);

            }
            if (!empty($is_used)) {
                $query->where('is_used', '=', $is_used);

            }
            if (!empty($config_uuid)) {
                $query->where('template_config_uuid', '=', $config_uuid);

            }
            if (!empty($is_used)) {
                $query->where('is_used', '=', $is_used);

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
        return $this->userSubscribeRepository->repositorySelect(self::searchWhere((array)$requestParams),
            (int)$requestParams['size'] ?? 20);
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
}