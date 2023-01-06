<?php
declare(strict_types = 1);

namespace App\Repository\Store\Book;

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
    /**
     * @Inject()
     * @var StoreBookContent
     */
    protected $contentModel;

    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = $this->contentModel::query()
            ->with(["book:uuid,title"])
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
        if (!empty($this->contentModel::query()->create($insertInfo))) {
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
        $bean = $this->contentModel::query()
            ->with(["book:uuid,title"])
            ->where($closure)
            ->select([
                "uuid",
                "store_uuid",
                "store_book_uuid",
                "store_book_category_uuid",
                "title",
                "intro",
                "content",
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
            ])->first();

        if (!empty($bean)) {
            return $bean->toArray();
        }
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return $this->contentModel::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return $this->contentModel::query()->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return $this->contentModel::query()->whereIn($field, $deleteWhere)->delete();
    }
}