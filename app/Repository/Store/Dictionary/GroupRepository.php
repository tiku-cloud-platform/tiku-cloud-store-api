<?php
declare(strict_types = 1);

namespace App\Repository\Store\Dictionary;

use App\Exception\DbDataMessageException;
use App\Exception\DbDuplicateMessageException;
use App\Model\Store\StoreDictionaryGroup;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Hyperf\DbConnection\Db;
use Throwable;

/**
 * 字典分组管理
 */
class GroupRepository implements StoreRepositoryInterface
{
    public function repositoryAllSelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreDictionaryGroup())::query()->where($closure)
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
        $items = (new StoreDictionaryGroup())::query()->where($closure)
            ->paginate($perSize, ["uuid", "store_uuid", "title", "code", "is_system", "is_show", "created_at", "updated_at", "remark"]);

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
            Db::beginTransaction();
            $newModel = (new StoreDictionaryGroup())::query()->create($insertInfo);
            if (!empty($newModel->getKey())) {
                Db::commit();
                return true;
            }
            Db::rollBack();
            return false;
        } catch (Throwable $throwable) {
            Db::rollBack();
            preg_match("/Duplicate entry/", $throwable->getMessage(), $msg);
            if (!empty($msg)) {
                throw new DbDuplicateMessageException("分组code已存在");
            } else {
                throw new DbDataMessageException("分组创建失败" . $throwable->getMessage());
            }
        }
    }

    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StoreDictionaryGroup())::query()->where($closure)->first([
            "uuid",
            "store_uuid",
            "title",
            "code",
            "is_system",
            "is_show",
            "created_at",
            "updated_at",
            "remark",
        ]);
        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreDictionaryGroup())::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StoreDictionaryGroup())::query()->where([
            ["is_system", "=", 2]
        ])->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StoreDictionaryGroup())::query()->where([
            ["is_system", "=", 2]
        ])->whereIn($field, $deleteWhere)->delete();
    }
}