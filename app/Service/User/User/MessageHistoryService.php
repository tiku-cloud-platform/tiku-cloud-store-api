<?php
declare(strict_types = 1);

namespace App\Service\User\User;


use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\User\User\MessageContentRepository;
use App\Repository\User\User\MessageHistoryRepository;
use App\Service\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * Class MessageHistoryService
 * @package App\Service\User\User
 */
class MessageHistoryService implements UserServiceInterface
{
    /**
     * @Inject()
     * @var MessageHistoryRepository
     */
    protected $messageHistoryRepository;

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
        $userInfo                    = UserInfo::getWeChatUserInfo();
        $requestParams['uuid']       = UUID::getUUID();
        $requestParams['store_uuid'] = $userInfo['store_uuid'];
        $requestParams['user_uuid']  = $userInfo['user_uuid'];

        return $this->messageHistoryRepository->repositoryCreate((array)$requestParams);
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
     * 查询消息未阅读数量
     *
     * @param array $requestParams
     * @return int
     */
    public function serviceCount(array $requestParams): int
    {
        // 查询总消息数量
        $messageCount = (new MessageContentRepository())->repositoryCount();
        // 查询当前已经阅读数量
        $historyCount = $this->messageHistoryRepository->repositoryCount((array)['user_uuid' => $requestParams['user_uuid']]);

        return ($messageCount - $historyCount) < 1 ? 0 : ($messageCount - $historyCount);
    }
}