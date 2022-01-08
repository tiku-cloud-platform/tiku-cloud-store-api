<?php
declare(strict_types = 1);

namespace App\Service\User\User;


use App\Repository\User\User\MessageContentRepository;
use App\Service\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台消息内容
 *
 * Class MessageContentService
 * @package App\Service\User\User
 */
class MessageContentService implements UserServiceInterface
{
    /**
     * @Inject()
     * @var MessageContentRepository
     */
    protected $messageRepository;

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
            if (!empty($platform_message_category_uuid)) {
                $query->where('platform_message_category_uuid', '=', $platform_message_category_uuid);
            }
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
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
        return $this->messageRepository->repositorySelect(
            self::searchWhere((array)$requestParams),
            (int)$requestParams['size'] ?? 20
        );
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
        (new MessageHistoryService())->serviceCreate((array)[
            'platform_message_content_uuid' => $requestParams['uuid'],
        ]);

        return $this->messageRepository->repositoryFind(self::searchWhere((array)$requestParams));
    }
}