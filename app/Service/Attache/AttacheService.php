<?php
declare(strict_types = 1);

namespace App\Service\Attache;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Attache\AttacheRepository;
use App\Service\StoreServiceInterface;
use Closure;

/**
 * 附件管理
 */
class AttacheService implements StoreServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($is_show)) {
                $query->where("is_show", "=", $is_show);
            }
            if (!empty($uuid)) {
                $query->where("uuid", "=", $uuid);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new AttacheRepository())->repositorySelect(self::searchWhere($requestParams),
            (int)($requestParams["size"]));
    }

    public function serviceCreate(array $requestParams): bool
    {
        $requestParams["store_uuid"] = UserInfo::getStoreUserStoreUuid();
        unset($requestParams["uuid"]);
        $requestParams["uuid"] = UUID::getUUID();
        return (new AttacheRepository())->repositoryCreate($requestParams);
    }

    public function serviceUpdate(array $requestParams): int
    {
        return (new AttacheRepository())->repositoryUpdate([["uuid", "=", $requestParams["uuid"]]], [
            "cate_uuid" => $requestParams["cate_uuid"],
            "title" => $requestParams["title"],
            "orders" => $requestParams["orders"],
            "is_show" => $requestParams["is_show"],
            "content" => $requestParams["content"],
            "download_number" => $requestParams["download_number"],
            "file_uuid" => $requestParams["file_uuid"],
            "attache_content" => $requestParams["attache_content"]
        ]);
    }

    public function serviceDelete(array $requestParams): int
    {
        $uuid = explode(",", $requestParams["uuid"]);
        if ($uuid !== false && count($uuid) > 0) {
            return (new AttacheRepository())->repositoryWhereInDelete($uuid, "uuid");
        }
        return 0;
    }

    public function serviceFind(array $requestParams): array
    {
        return (new AttacheRepository())->repositoryFind(self::searchWhere($requestParams));
    }
}