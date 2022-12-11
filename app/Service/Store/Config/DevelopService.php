<?php
declare(strict_types = 1);

namespace App\Service\Store\Config;

use App\Repository\Store\Config\DevelopRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 商户开发配置
 */
class DevelopService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var DevelopRepository
     */
    protected $configRepository;

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
        return $this->configRepository->repositoryFind(self::searchWhere($requestParams));
    }
}