<?php
declare(strict_types = 1);

namespace App\Service\Store\Message;


use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Message\ContentRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台消息内容
 *
 * Class ContentService
 * @package App\Service\Store\Message
 */
class ContentService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var ContentRepository
     */
    protected $contentRepository;

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
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
            if (!empty($platform_message_category_uuid)) {
                $query->where('platform_message_category_uuid', '=', $platform_message_category_uuid);
            }
            if (!empty($title)) {
                $query->where('title', 'like', '%' . $title . '%');
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
        return $this->contentRepository->repositorySelect(
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
        $requestParams['uuid']       = UUID::getUUID();
        $requestParams['store_uuid'] = UserInfo::getStoreUserInfo()['store_uuid'];

        return $this->contentRepository->repositoryCreate($requestParams);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        return $this->contentRepository->repositoryUpdate((array)[
            ['uuid', '=', trim($requestParams['uuid'])],
        ], (array)[
            'title'                          => trim($requestParams['title']),
            'platform_message_category_uuid' => trim($requestParams['platform_message_category_uuid']),
            'content'                        => trim($requestParams['content']),
            'is_show'                        => trim($requestParams['is_show']),
        ]);
    }

    /**
     * 删除数据
     *
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams): int
    {
        $uuidArray   = explode(',', $requestParams['uuid']);
        $deleteWhere = [];
        foreach ($uuidArray as $value) {
            array_push($deleteWhere, $value);
        }

        return $this->contentRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->contentRepository->repositoryFind(self::searchWhere((array)$requestParams));
    }
}