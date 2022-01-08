<?php
declare(strict_types = 1);

namespace App\Service\User\User;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\User\User\TemplateSubscribeRepository;
use App\Service\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 微信订阅消息记录
 *
 * Class TemplateSubscribeService
 * @package App\Service\User\User
 */
class TemplateSubscribeService implements UserServiceInterface
{
    /**
     * @Inject()
     * @var TemplateSubscribeRepository
     */
    protected $subscribeRepository;

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
        // TODO: Implement searchWhere() method.
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
        $userInfo                              = UserInfo::getWeChatUserInfo();
        $requestParams['uuid']                 = UUID::getUUID();
        $requestParams['user_uuid']            = $userInfo['user_uuid'];
        $requestParams['store_uuid']           = $userInfo['store_uuid'];
        $requestParams['template_config_uuid'] = $requestParams['template_uuid'];

        return $this->subscribeRepository->repositoryCreate((array)$requestParams);
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
     * @return array
     */
    public function serviceFind(array $requestParams): array
    {
        // TODO: Implement serviceFind() method.
    }
}