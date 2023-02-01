<?php
declare(strict_types = 1);

namespace App\Service\File;

use App\Library\File\CloudStorageToken;
use App\Service\Config\PlatformSettingService;
use App\Service\StoreServiceInterface;

/**
 * 第三方云存储token管理.
 *
 * Class TokenService
 */
class TokenService implements StoreServiceInterface
{
    public function __construct()
    {
    }

    /**
     * 格式化查询条件.
     * @param array $requestParams 请求参数
     * @return mixed 组装的查询条件
     */
    public static function searchWhere(array $requestParams)
    {
        return function () {
        };
    }

    /**
     * 查询数据.
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        return [];
    }

    /**
     * 创建数据.
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        return false;
    }

    /**
     * 更新数据.
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        unset($requestParams["creator"]);
        return 1;
    }

    /**
     * 删除数据.
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams): int
    {
        return 1;
    }

    /**
     * 查询单条数据.
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return [];
    }

    /**
     * 获取文件上传token
     * @return array
     */
    public function serviceUploadToken(): array
    {
        $bean        = (new PlatformSettingService())->serviceFind(['type' => 'file_upload']);
        $cloudConfig = $bean['values'][$bean['values']['default']];
        return [
            'driver' => $bean['values']['default'],
            'token' => (new CloudStorageToken)->getToken((string)$bean['values']['default'], (array)$cloudConfig)['token'],
            'values' => $cloudConfig
        ];
    }
}
