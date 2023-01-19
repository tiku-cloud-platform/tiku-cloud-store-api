<?php
declare(strict_types = 1);

namespace App\Service\File;


use App\Repository\File\FileRepository;
use App\Service\Config\PlatformSettingService;
use App\Service\StoreServiceInterface;

/**
 * 平台文件管理
 *
 * Class FileService
 * @package App\Service\Store\File
 */
class FileService implements StoreServiceInterface
{
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
            if (!empty($file_group_uuid)) {// 根据顶级分类查询所有图片
                $fileGroupInfo = (new FileGroupService)->serviceFind(['uuid' => $file_group_uuid]);
                $searchWhere   = [];
                if (empty($fileGroupInfo['parent_uuid'])) {// 一级分类
                    $items = (new FileGroupService())->serviceAllIn(['uuid' => $file_group_uuid], 'parent_uuid');
                    foreach ($items as $value) {
                        array_push($searchWhere, $value['uuid']);
                    }
                    array_push($searchWhere, $file_group_uuid);
                } else {
                    array_push($searchWhere, $file_group_uuid);
                }
                $query->whereIn('file_group_uuid', $searchWhere);
            }
            if (!empty($file_name)) {
                $query->where('file_name', 'like', '%' . $file_name . '%');
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
        $items = (new FileRepository)->repositorySelect(
            self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20
        );

        return $items;
    }

    /**
     * 创建数据
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        /** @var array $fileConfig 文件上传配置 */
        $fileConfig = (new PlatformSettingService())->serviceFind(['type' => 'file_upload']);
        if (empty($fileConfig)) {
            return false;
        }
        $fileDomain    = $fileConfig['values'][$fileConfig['values']['default']]['domain'];
        $fileInfoArray = [];
        $fileInfo      = json_decode($requestParams['file_info'], true);
        foreach ($fileInfo as $key => $value) {
            $fileInfoArray[$key]['storage']         = $requestParams['storage'];
            $fileInfoArray[$key]['file_url']        = $fileDomain;
            $fileInfoArray[$key]['file_name']       = $value['file_name'];
            $fileInfoArray[$key]['file_size']       = $value['file_size'];
            $fileInfoArray[$key]['file_type']       = $value['file_type'];
            $fileInfoArray[$key]['extension']       = $value['extension'];
            $fileInfoArray[$key]['file_hash']       = $value['hash_name'];
            $fileInfoArray[$key]['file_group_uuid'] = $requestParams['file_group_uuid'];
        }

        return (new FileRepository)->repositoryCreate($fileInfoArray);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {

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

        return (new FileRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return (new FileRepository)->repositoryFind(self::searchWhere($requestParams));
    }
}