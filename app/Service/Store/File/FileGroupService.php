<?php

declare(strict_types = 1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Service\Store\File;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\File\FileGroupRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台文件组配置
 *
 * Class FileGroupService
 */
class FileGroupService implements StoreServiceInterface
{
    /**
     * @Inject
     * @var FileGroupRepository
     */
    private $fileGroupRepository;

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
        return $this->fileGroupRepository->repositorySelect(
            self::searchWhere((array)$requestParams),
            (int)$requestParams['size'] ?? 20
        );
    }

    /**
     * 查询顶级分类
     *
     * @param array $requestParams
     * @return array
     */
    public function serviceParentSelect(array $requestParams): array
    {
        return $this->fileGroupRepository->repositoryParentSelect(self::searchWhere((array)$requestParams),
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
        $requestParams['uuid']        = UUID::getUUID();
        $requestParams['parent_uuid'] = empty($requestParams['parent_uuid']) ? null : $requestParams['parent_uuid'];
        $requestParams['store_uuid']  = UserInfo::getStoreUserInfo()['store_uuid'];

        return $this->fileGroupRepository->repositoryCreate($requestParams);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        return $this->fileGroupRepository->repositoryUpdate((array)[
            ['uuid', '=', trim($requestParams['uuid'])],
        ], (array)[
            'title'       => trim($requestParams['title']),
            'is_show'     => trim($requestParams['is_show']),
            'parent_uuid' => !empty($requestParams['parent_uuid']) ? trim($requestParams['parent_uuid']) : null,
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

        return $this->fileGroupRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->fileGroupRepository->repositoryFind(self::searchWhere((array)$requestParams));
    }

    /**
     * 查询全部数据
     *
     * @param array $requestParams
     * @param string $searchField
     * @return array
     */
    public function serviceAllIn(array $requestParams, string $searchField): array
    {
        $searchValue = [];
        if (!empty($requestParams['uuid'])) {
            array_push($searchValue, $requestParams['uuid']);
        }

        return $this->fileGroupRepository->repositoryAllIn((array)$searchValue, (string)$searchField);
    }
}
