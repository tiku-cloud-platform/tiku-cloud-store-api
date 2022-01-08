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

use App\Library\File\CloudStorageToken;
use App\Service\Store\Config\PlatformSettingService;
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
     *
     * @param array $requestParams 请求参数
     * @return mixed 组装的查询条件
     */
    public static function searchWhere(array $requestParams)
    {
        // TODO: Implement searchWhere() method.
    }

    /**
     * 查询数据.
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    /**
     * 创建数据.
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        // TODO: Implement serviceCreate() method.
    }

    /**
     * 更新数据.
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        // TODO: Implement serviceUpdate() method.
    }

    /**
     * 删除数据.
     *
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    /**
     * 查询单条数据.
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {

    }

    /**
     * 获取文件上传token
     *
     * @return array
     */
    public function serviceUploadToken(): array
    {
        $bean = (new PlatformSettingService())->serviceFind((array)['type' => 'file_upload']);

        $cloudConfig = $bean['values'][$bean['values']['default']];

        return [
            'driver' => $bean['values']['default'],
            'token'  => (new CloudStorageToken)->getToken((string)$bean['values']['default'], (array)$cloudConfig)['token'],
            'values' => $cloudConfig
        ];
    }
}
