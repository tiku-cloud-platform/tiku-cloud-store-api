<?php
declare(strict_types = 1);

namespace App\Repository\Book;

use App\Model\Store\StoreBookContent;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 书籍内容
 * @package App\Repository\Store\Book
 */
class ContentRepository implements StoreRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreBookContent)::query()
            ->with(["book:uuid,title"])
            ->with(['creator:id,name'])
            ->where($closure)
            ->select([
                "uuid",
                "store_uuid",
                "store_book_uuid",
                "store_book_category_uuid",
                "title",
                "author",
                "publish_time",
                "tags",
                "read_number",
                "click_number",
                "collection_number",
                "source",
                "is_show",
                "orders",
                "created_at",
                "updated_at",
                "read_score",
                "share_score",
                "click_score",
                "collection_score",
                "read_expend_score",
                "create_id",
            ])
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
        if (!empty((new StoreBookContent)::query()->create($insertInfo))) {
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
        $bean = (new StoreBookContent)::query()
            ->where($closure)
            ->select([
                "uuid",
                "store_book_category_uuid",
                "store_book_uuid",
                "title",
                "intro",
                "content",
                "author",
                "publish_time",
                "tags",
                "source",
                "is_show",
                "orders",
                "read_score",
                "share_score",
                "click_score",
                "collection_score",
                "read_expend_score",
                "create_id",
                "content_type",
            ])->first();

        return !empty($bean) ? $bean->toArray() : [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreBookContent)::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StoreBookContent)::query()->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StoreBookContent)::query()->whereIn($field, $deleteWhere)->delete();
    }
}