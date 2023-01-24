<?php
declare(strict_types = 1);

namespace App\Repository\Config;

use App\Exception\DbDataMessageException;
use App\Model\Store\StorePage;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Throwable;

/**
 * 商户页面
 */
class PageRepository implements StoreRepositoryInterface
{
    public function repositoryAllSelect(Closure $closure, int $perSize): array
    {
        $items = (new StorePage())::query()->where($closure)
            ->paginate($perSize, ["uuid", "title"]);

        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $perSize,
            "total" => $items->total(),
        ];
    }

    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StorePage())::query()->where($closure)
            ->with(['creator:id,name'])
            ->paginate($perSize, [
                "uuid",
                "store_uuid",
                "title",
                "path",
                "remark",
                "is_show",
                "created_at",
                "updated_at",
                "create_id",
            ]);

        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $perSize,
            "total" => $items->total(),
        ];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            $newModel = (new StorePage())::query()->create($insertInfo);
            if (!empty($newModel->getKey())) {
                return true;
            }
            return false;
        } catch (Throwable $throwable) {
            throw new DbDataMessageException("分组创建失败" . $throwable->getMessage());
        }
    }

    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StorePage())::query()
            ->with(['creator:id,name'])
            ->where($closure)
            ->first([
                "uuid",
                "store_uuid",
                "title",
                "path",
                "remark",
                "is_show",
                "created_at",
                "updated_at",
                "create_id",
            ]);
        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StorePage())::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StorePage())::query()->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StorePage())::query()->whereIn($field, $deleteWhere)->delete();
    }
}