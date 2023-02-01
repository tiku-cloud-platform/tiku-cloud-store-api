<?php
declare(strict_types = 1);

namespace App\Service\Dictionary;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Dictionary\GroupRepository;
use App\Service\StoreServiceInterface;
use Closure;

/**
 * 字典分组管理
 */
class GroupService implements StoreServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where("uuid", "=", $uuid);
            }
            if (!empty($is_show)) {
                $query->where("is_show", "=", $is_show);
            }
            if (!empty($title)) {
                $query->where("title", "like", "%" . $title . "%");
            }
        };
    }

    public function serviceAll(array $requestParams): array
    {
        return (new GroupRepository())->repositoryAllSelect(self::searchWhere($requestParams),
            (int)($requestParams["size"] ?? 20));
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new GroupRepository())->repositorySelect(self::searchWhere($requestParams),
            (int)($requestParams["size"] ?? 20));
    }

    public function serviceCreate(array $requestParams): bool
    {
        $requestParams["uuid"]       = UUID::getUUID();
        $requestParams["is_system"]  = 2;
        $requestParams["store_uuid"] = UserInfo::getStoreUserInfo()['store_uuid'];
        return (new GroupRepository())->repositoryCreate($requestParams);
    }

    public function serviceUpdate(array $requestParams): int
    {
        unset($requestParams["creator"]);
        $uuid = $requestParams["uuid"];
        unset($requestParams["uuid"]);
        return (new GroupRepository())->repositoryUpdate([
            ["uuid", "=", $uuid]
        ], $requestParams);
    }

    public function serviceDelete(array $requestParams): int
    {
        $uuidArray = explode(",", $requestParams["uuid"]);
        if (is_bool($uuidArray)) return 0;
        return (new GroupRepository())->repositoryWhereInDelete($uuidArray, "uuid");
    }

    public function serviceFind(array $requestParams): array
    {
        return (new GroupRepository())->repositoryFind(self::searchWhere($requestParams));
    }
}