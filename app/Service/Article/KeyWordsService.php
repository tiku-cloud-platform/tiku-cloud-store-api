<?php
declare(strict_types = 1);

namespace App\Service\Article;

use App\Mapping\UserInfo;
use App\Repository\Article\KeyWordsRepository;
use App\Service\StoreServiceInterface;
use Closure;

/**
 * 文章关键词搜索
 */
class KeyWordsService implements StoreServiceInterface
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

    public function serviceSelect(array $requestParams): array
    {
        return (new KeyWordsRepository())->repositorySelect(self::searchWhere($requestParams),
            (int)($requestParams["size"] ?? 20));
    }

    public function serviceCreate(array $requestParams): bool
    {
        $requestParams["create_id"]  = UserInfo::getStoreUserInfo()["id"];
        $requestParams["store_uuid"] = UserInfo::getStoreUserStoreUuid();

        return (new KeyWordsRepository())->repositoryCreate($requestParams);
    }

    public function serviceUpdate(array $requestParams): int
    {
        return (new KeyWordsRepository())->repositoryUpdate([
            ["uuid", "=", $requestParams["uuid"]]
        ], [
            "title" => trim($requestParams["title"]),
            "is_show" => $requestParams["is_show"],
            "orders" => $requestParams["orders"]
        ]);
    }

    public function serviceDelete(array $requestParams): int
    {
        $uuidArray   = explode(',', $requestParams['uuid']);
        $deleteWhere = [];
        foreach ($uuidArray as $value) {
            $deleteWhere[] = $value;
        }
        if (count($deleteWhere) === 0) return 0;
        return (new KeyWordsRepository())->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    public function serviceFind(array $requestParams): array
    {
        return (new KeyWordsRepository())->repositoryFind(self::searchWhere($requestParams));
    }
}