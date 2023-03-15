<?php
declare(strict_types = 1);

namespace App\Repository\Book;

use App\Model\Store\StoreBookEvaluateHistory;
use App\Repository\StoreRepositoryInterface;
use Closure;

/**
 * 审核管理
 */
class EvaluateHistoryRepository implements StoreRepositoryInterface
{

    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreBookEvaluateHistory())::query()
            ->with(["mini:user_uuid,avatar_url,nickname"])
            ->with(["user:uuid,mobile,email,real_name"])
            ->with(["audit:uuid,name"])
            ->where($closure)
            ->orderByDesc("id")
            ->select(["score", "content", "uuid", "user_uuid", "uuid", "is_show", "created_at", "audit_at", "audit_user_uuid"])
            ->paginate($perSize);

        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $perSize,
            "total" => $items->total(),
        ];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        // TODO: Implement repositoryCreate() method.
    }

    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StoreBookEvaluateHistory())::query()
            ->with(["mini:user_uuid,avatar_url,nickname"])
            ->with(["user:uuid,mobile,email,real_name"])
            ->where($closure)
            ->first(["score", "content", "uuid", "user_uuid", "uuid", "is_show", "created_at", "audit_at", "audit_user_uuid"]);

        return !empty($bean) ? $bean->toArray() : [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreBookEvaluateHistory())::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        // TODO: Implement repositoryDelete() method.
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        // TODO: Implement repositoryWhereInDelete() method.
    }
}