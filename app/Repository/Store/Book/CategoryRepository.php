<?php
declare(strict_types = 1);

namespace App\Repository\Store\Book;

use App\Model\Store\StoreBookCategory;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 书籍目录
 * @package App\Repository\Store\Book
 */
class CategoryRepository implements StoreRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreBookCategory)::query()
//			->with(["book:uuid,title"])
            ->where($closure)
            ->select([
                "uuid",
//				"store_book_uuid",
                "title",
                "parent_uuid",
//				"is_show",
//				"orders",
//				"created_at",
//				"updated_at",
            ])
            ->orderBy('id')
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
            ->select([
                "uuid",
//                "store_book_uuid",
                "title",
                "parent_uuid",
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