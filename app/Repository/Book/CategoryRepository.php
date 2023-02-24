<?php
declare(strict_types = 1);

namespace App\Repository\Book;

use App\Model\Store\StoreBookCategory;
use App\Repository\StoreRepositoryInterface;
use Closure;

/**
 * 书籍目录
 * @package App\Repository\Store\Book
 */
class CategoryRepository implements StoreRepositoryInterface
{
    public function repositoryAll(Closure $closure): array
    {
        $items = (new StoreBookCategory())::query()
            ->where($closure)
            ->where([
                ["parent_uuid", "=", ""],
                ["is_show", "=", 1]
            ])->get(["uuid", "title"]);

        return !empty($items) ? $items->toArray() : [];
    }

    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreBookCategory)::query()
//			->with(["book:uuid,title"])
            ->with(['creator:id,name'])
            ->where($closure)
            ->where("parent_uuid", "=", "")
            ->select([
                "uuid",
//				"store_book_uuid",
                "title",
                "parent_uuid",
                "create_id",
//				"is_show",
                "orders",
//				"created_at",
//				"updated_at",
            ])
            ->orderBy('orders')
            ->paginate($perSize);

        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size' => $items->perPage(),
            'page' => $items->currentPage(),
        ];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        if (!empty((new StoreBookCategory)::query()->create($insertInfo))) {
            return true;
        }

        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreBookCategory)::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StoreBookCategory)::query()->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StoreBookCategory)::query()->whereIn($field, $deleteWhere)->delete();
    }

    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StoreBookCategory)::query()
//            ->with(["book:uuid,title"])
            ->with(['creator:id,name'])
            ->select([
                "uuid",
//                "store_book_uuid",
                "title",
                "parent_uuid",
                "create_id",
//                "is_show",
//                "orders",
//                "created_at",
//                "updated_at",
            ])
            ->where($closure)
            ->first();

        if (!empty($bean)) {
            return $bean->toArray();
        }
        return [];
    }

    public function repositorySpecial(array $searchWhere, array $fields = ["id"]): array
    {
        $items = (new StoreBookCategory)::query()
            ->where($searchWhere)
            ->get($fields);
        if (!empty($items)) {
            return $items->toArray();
        }
        return [];
    }
}