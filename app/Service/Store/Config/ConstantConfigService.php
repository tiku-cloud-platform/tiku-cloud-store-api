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

namespace App\Service\Store\Config;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Config\ConstantConfigRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 商户平台常量配置.
 *
 * Class ConstantConfigService
 */
class ConstantConfigService implements StoreServiceInterface
{
    /**
     * @Inject
     * @var ConstantConfigRepository
     */
    private $configRepository;

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
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
            if (!empty($title)) {
                $query->where('title', '=', $title);
            }
            if (!empty($value)) {
                $query->where('value', 'like', '%' . $value . '%');
            }
            if (!empty($describe)) {
                $query->where('describe', 'like', '%' . $describe . '%');
            }
        };
    }

    /**
     * 查询数据.
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        return $this->configRepository->repositorySelect(
            self::searchWhere((array)$requestParams),
            (int)$requestParams['size'] ?? 20
        );
    }

    /**
     * 创建数据.
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        $requestParams['uuid']       = UUID::getUUID();
        $requestParams['store_uuid'] = UserInfo::getStoreUserInfo()['store_uuid'];

        return $this->configRepository->repositoryCreate($requestParams);
    }

    /**
     * 更新数据.
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        return $this->configRepository->repositoryUpdate((array)[
            ['uuid', '=', trim($requestParams['uuid'])],
        ], (array)[
            'title'    => trim($requestParams['title']),
            'describe' => trim($requestParams['describe']),
            'value'    => trim($requestParams['value']),
        ]);
    }

    /**
     * 删除数据.
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

        return $this->configRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'uuid');
    }

    /**
     * 查询单条数据.
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->configRepository->repositoryFind(self::searchWhere((array)$requestParams));
    }
}
