<?php
declare(strict_types = 1);

namespace App\Service\User;

use App\Repository\User\UserRepository;
use App\Service\StoreServiceInterface;

/**
 * 平台用户
 * Class UserService
 * @package App\Service\Store\User
 */
class UserService implements StoreServiceInterface
{
    public static function searchWhere(array $requestParams)
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($user_uuid)) {
                $query->where("uuid", "=", $user_uuid);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new UserRepository)->repositorySelect(
            self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20
        );
    }

    public function serviceCreate(array $requestParams): bool
    {

    }

    public function serviceUpdate(array $requestParams): int
    {
        return (new UserRepository)->repositoryUpdate([
            ['uuid', '=', trim($requestParams['uuid'])],
        ], [
            'is_forbidden' => trim($requestParams['is_forbidden'])
        ]);
    }

    public function serviceDelete(array $requestParams): int
    {
        return 1;
    }

    public function serviceFind(array $requestParams): array
    {
        $bean               = (new UserRepository())->repositoryAllFind(self::searchWhere($requestParams));
        $bean["created_at"] = date("Y-m-d", strtotime($bean["created_at"]));
        return $bean;
    }
}