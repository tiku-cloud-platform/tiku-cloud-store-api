<?php
declare(strict_types = 1);

namespace App\Service\Book;

use App\Mapping\UserInfo;
use App\Repository\Book\EvaluateHistoryRepository;
use App\Service\StoreServiceInterface;
use Closure;

/**
 * 审核管理
 */
class EvaluateHistoryService implements StoreServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($book_uuid)) {
                $query->where("book_uuid", "=", $book_uuid);
            }
            if (!empty($uuid)) {
                $query->where("uuid", "=", $uuid);
            }
            if (!empty($is_show)) {
                $query->where("is_show", "=", $is_show);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new EvaluateHistoryRepository())->repositorySelect(self::searchWhere($requestParams),
            (int)($requestParams["size"]));
    }

    public function serviceCreate(array $requestParams): bool
    {
        // TODO: Implement serviceCreate() method.
    }

    public function serviceUpdate(array $requestParams): int
    {
        return (new EvaluateHistoryRepository())->repositoryUpdate([
            ["uuid", "=", $requestParams["uuid"]]
        ], [
            "content" => $requestParams["content"],
            "audit_at" => date("Y-m-d H:i:s"),
            "is_show" => $requestParams["is_show"],
            "audit_user_uuid" => UserInfo::getStoreUserInfo()["uuid"] ?? ""
        ]);
    }

    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    public function serviceFind(array $requestParams): array
    {
        // TODO: Implement serviceFind() method.
    }
}