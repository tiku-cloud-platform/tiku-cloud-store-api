<?php
declare(strict_types = 1);

namespace App\Repository\Store\Book;

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
    /**
     * @Inject()
     * @var StoreBook
     */
    protected $bookModel;

    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = $this->bookModel::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
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
        if (!empty($this->bookModel::query()->create($insertInfo))) {
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
        $bean = $this->bookModel::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
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
        return $this->bookModel::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return $this->bookModel::query()->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return $this->bookModel::query()->whereIn($field, $deleteWhere)->delete();
    }
}