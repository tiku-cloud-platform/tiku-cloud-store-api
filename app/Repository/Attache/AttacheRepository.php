<?php
declare(strict_types = 1);

namespace App\Repository\Attache;

use App\Model\Store\StoreAttache;
use App\Repository\StoreRepositoryInterface;
use Closure;

/**
 * 附件管理
 */
class AttacheRepository implements StoreRepositoryInterface
{

    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreAttache())::query()
            ->with(['cover:uuid,file_url,file_name'])
            ->with(["cate:uuid,title"])
            ->with(["creator:id,name"])
            ->where($closure)
            ->orderByDesc("id")
            ->paginate($perSize, ["uuid", "cate_uuid", "title", "content", "type", "score", "url",
                "download_number", "is_show", "orders", "created_at", "file_uuid", "create_id"]);

        return [
            "items" => $items->items(),
            "total" => $items->total(),
            "page" => $items->currentPage(),
            "size" => $items->perPage(),
        ];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        $newModel = (new StoreAttache())::query()->create($insertInfo);
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
        $bean = (new StoreAttache())::query()
            ->with(['cover:uuid,file_url,file_name'])
            ->where($closure)
            ->first(["uuid", "cate_uuid", "title", "content", "type", "score", "url",
                "download_number", "is_show", "orders", "created_at", "file_uuid", "create_id", "attache_content"]);

        return !empty($bean) ? $bean->toArray() : [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreAttache())::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return 0;
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StoreAttache())::query()->whereIn($field, $deleteWhere)->delete();
    }
}