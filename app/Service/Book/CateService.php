<?php
declare(strict_types = 1);

namespace App\Service\Book;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Book\CateRepository;
use App\Service\StoreServiceInterface;
use Closure;

/**
 * 教程分类
 */
class CateService implements StoreServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($is_show)) {
                $query->where("is_show", "=", $is_show);
            }
            if (!empty($is_home)) {
                $query->where("is_home", "=", $is_home);
            }
        };
    }

    public function serviceAll(): array
    {
        return (new CateRepository())->repositoryAll();
    }

    public function serviceTree(): array
    {
        return (new CateRepository())->repositoryTree();
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new CateRepository())->repositorySelect(self::searchWhere($requestParams),
            (int)($requestParams["size"]));
    }

    public function serviceCreate(array $requestParams): bool
    {
        $requestParams["store_uuid"] = UserInfo::getStoreUserStoreUuid();
        unset($requestParams["uuid"]);
        $requestParams["uuid"]        = UUID::getUUID();
        $requestParams["parent_uuid"] = empty($requestParams["parent_uuid"]) ? null : $requestParams["parent_uuid"];
        return (new CateRepository())->repositoryCreate($requestParams);
    }

    public function serviceUpdate(array $requestParams): int
    {
        if (empty($requestParams["parent_uuid"])) {
            $requestParams["parent_uuid"] = null;
        }
        return (new CateRepository())->repositoryUpdate([["uuid", "=", $requestParams["uuid"]]], [
            "parent_uuid" => $requestParams["parent_uuid"],
            "title" => $requestParams["title"],
            "orders" => $requestParams["orders"],
            "is_home" => $requestParams["is_home"],
            "is_show" => $requestParams["is_show"]
        ]);
    }

    public function serviceDelete(array $requestParams): int
    {
        $uuid = explode(",", $requestParams["uuid"]);
        if ($uuid !== false && count($uuid) > 0) {
            return (new CateRepository())->repositoryWhereInDelete($uuid, "uuid");
        }
        return 0;
    }

    public function serviceFind(array $requestParams): array
    {
        return [];
    }
}