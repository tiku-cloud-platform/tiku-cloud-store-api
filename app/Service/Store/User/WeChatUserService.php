<?php
declare(strict_types = 1);

namespace App\Service\Store\User;

use App\Repository\Store\User\WeChatUserRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 微信小程序
 * Class WeChatUserService
 * @package App\Service\Store\User
 */
class WeChatUserService implements StoreServiceInterface
{
    /**
     * @inheritDoc
     */
    public static function searchWhere(array $requestParams)
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where('user_uuid', '=', $uuid);
            }
        };
    }

    /**
     * @inheritDoc
     */
    public function serviceSelect(array $requestParams): array
    {
        return (new WeChatUserRepository)->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
    }

    /**
     * @inheritDoc
     */
    public function serviceCreate(array $requestParams): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function serviceUpdate(array $requestParams): int
    {
        return 1;
    }

    /**
     * @inheritDoc
     */
    public function serviceDelete(array $requestParams): int
    {
        return 1;
    }

    /**
     * @inheritDoc
     */
    public function serviceFind(array $requestParams): array
    {
        return [];
    }
}