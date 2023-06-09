<?php
declare(strict_types = 1);

namespace App\Service\Book;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Book\CategoryRepository;
use App\Service\StoreServiceInterface;
use Closure;

class CategoryService implements StoreServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            $query->where("store_book_uuid", "=", $store_book_uuid);
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
            if (!empty($title)) {
                $query->where('title', 'like', '%' . $title . '%');
            }
        };
    }

    public function serviceAllSelect(array $requestParams): array
    {
        return (new CategoryRepository())->repositoryAll(self::searchWhere($requestParams));
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new CategoryRepository())->repositorySelect(
            self::searchWhere($requestParams),
            (int)($requestParams['size'] ?? 20)
        );
    }

    public function serviceCreate(array $requestParams): bool
    {
        $requestParams["uuid"]        = UUID::getUUID();
        $requestParams['store_uuid']  = UserInfo::getStoreUserInfo()['store_uuid'];
        $requestParams["parent_uuid"] = empty($requestParams["parent_uuid"]) ? null : $requestParams["parent_uuid"];

        return (new CategoryRepository)->repositoryCreate($requestParams);
    }

    public function serviceUpdate(array $requestParams): int
    {
        unset($requestParams["creator"]);
        if (!isset($requestParams["uuid"])) return 0;
        $uuid = $requestParams["uuid"];
        unset($requestParams["uuid"]);
        $requestParams["parent_uuid"] = empty($requestParams["parent_uuid"]) ? null : $requestParams["parent_uuid"];
        return (new CategoryRepository)->repositoryUpdate([
            ['uuid', '=', $uuid],
        ], $requestParams);
    }

    public function serviceDelete(array $requestParams): int
    {
        $uuidArray   = explode(',', $requestParams['uuid']);
        $deleteWhere = [];
        foreach ($uuidArray as $value) {
            $deleteWhere[] = $value;
        }

        return (new CategoryRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    public function serviceFind(array $requestParams): array
    {
        return (new CategoryRepository)->repositoryFind(self::searchWhere($requestParams));
    }
}