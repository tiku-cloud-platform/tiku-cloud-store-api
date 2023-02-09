<?php
declare(strict_types = 1);

namespace App\Repository\Article;

use App\Mapping\UUID;
use App\Model\Store\StoreArticleKeyWords;
use App\Repository\StoreRepositoryInterface;
use Closure;

/**
 * 文章关键词搜索
 */
class KeyWordsRepository implements StoreRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreArticleKeyWords())::query()
            ->with(['creator:id,name'])
            ->where($closure)
            ->select(["uuid", "title", "is_show", "created_at", "updated_at", "create_id", "orders"])
            ->paginate($perSize);

        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $items->perPage(),
            "total" => $items->total()
        ];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        $insertInfo["uuid"] = UUID::getUUID();
        if ((new StoreArticleKeyWords())::query()->create($insertInfo)) return true;
        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StoreArticleKeyWords())::query()
            ->where($closure)
            ->first(["uuid", "title", "is_show", "created_at", "updated_at", "create_id", "orders"]);

        return !empty($bean) ? $bean->toArray() : [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreArticleKeyWords())::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StoreArticleKeyWords())::query()->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StoreArticleKeyWords())::query()->whereIn($field, $deleteWhere)->delete();
    }
}