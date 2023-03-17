<?php
declare(strict_types = 1);

namespace App\Repository\Attache;

use App\Model\Store\StoreAttacheCate;
use App\Repository\StoreRepositoryInterface;
use Closure;

/**
 * 附件分类
 */
class CateRepository implements StoreRepositoryInterface
{
    public function repositoryAll(): array
    {
        return (new StoreAttacheCate())::query()
            ->where("is_show", "=", 1)
            ->whereNull("parent_uuid")
            ->get(["uuid", "parent_uuid", "title"])
            ->toArray();
    }

    public function repositoryTree(): array
    {
        return (new StoreAttacheCate())::query()
            ->with(["children:uuid,title,parent_uuid"])
            ->whereNull("parent_uuid")
            ->where("is_show", "=", 1)
            ->get(["uuid", "parent_uuid", "title"])
            ->toArray();
    }

    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreAttacheCate())::query()
            ->with(["creator:id,name"])
            ->with(["children:uuid,title,parent_uuid,is_show,orders,created_at,updated_at,create_id"])
            ->where($closure)
            ->whereNull("parent_uuid")
            ->orderByDesc("id")
            ->paginate($perSize,
                ["uuid", "title", "parent_uuid", "is_show", "orders", "created_at", "updated_at", "create_id"]);

        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $items->perPage(),
            "total" => $items->total()
        ];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        $newModel = (new StoreAttacheCate())::query()->create($insertInfo);
        if (!empty($newModel->getAttribute("uuid"))) {
            return true;
        }
        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(Closure $closure): array
    {
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreAttacheCate())::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return 0;
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StoreAttacheCate())::query()->whereIn($field, $deleteWhere)->delete();
    }

}