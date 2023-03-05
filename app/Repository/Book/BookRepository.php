<?php
declare(strict_types = 1);

namespace App\Repository\Book;

use App\Model\Store\StoreBook;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 书籍基础信息
 * @package App\Repository\Store\Book
 */
class BookRepository implements StoreRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreBook)::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->with(['creator:id,name'])
            ->where($closure)
            ->select([
                "uuid",
                "file_uuid",
                "title",
                "author",
                "tags",
                "source",
                "numbers",
                "intro",
                "collection_number",
                "level",
                "score",
                "is_show",
                "orders",
                "created_at",
                "updated_at",
                "click_number",
                "create_id",
            ])
            ->orderByDesc('id')
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
        if (!empty((new StoreBook)::query()->create($insertInfo))) {
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
        $bean = (new StoreBook)::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->with(['creator:id,name'])
            ->select([
                "uuid",
                "file_uuid",
                "title",
                "author",
                "tags",
                "source",
                "numbers",
                "intro",
                "collection_number",
                "level",
                "score",
                "is_show",
                "orders",
                "created_at",
                "updated_at",
                "click_number",
                "create_id",
                "content_desc",
            ])
            ->where($closure)
            ->first();

        if (!empty($bean)) {
            return $bean->toArray();
        }
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreBook)::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StoreBook)::query()->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StoreBook)::query()->whereIn($field, $deleteWhere)->delete();
    }
}