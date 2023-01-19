<?php
declare(strict_types = 1);

namespace App\Service\Config;

use App\Repository\Config\DevelopRepository;
use App\Service\StoreServiceInterface;

/**
 * 商户开发配置
 */
class DevelopService implements StoreServiceInterface
{
    public static function searchWhere(array $requestParams)
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($store_uuid)) {
                $query->where("store_uuid", "=", $store_uuid);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    public function serviceCreate(array $requestParams): bool
    {
        // TODO: Implement serviceCreate() method.
    }

    public function serviceUpdate(array $requestParams): int
    {
        // TODO: Implement serviceUpdate() method.
    }

    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    /**
     * 商户开发配置
     * @param array $requestParams
     * @return array
     */
    public function serviceFind(array $requestParams): array
    {
        return (new DevelopRepository)->repositoryFind(self::searchWhere($requestParams));
    }
}