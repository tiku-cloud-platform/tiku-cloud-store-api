<?php
declare(strict_types = 1);

namespace App\Repository\Store\Dictionary;

use App\Model\Store\StoreDictionary;
use App\Repository\StoreRepositoryInterface;
use Closure;

/**
 * 字典明细
 */
class DictionaryRepository implements StoreRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreDictionary())::query()->where($closure)->paginate($perSize, ["uuid", "title", "store_uuid",
            "group_uuid", "is_show", "created_at", "updated_at", "remark"]);

        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $perSize,
            "total" => $items->total(),
        ];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        $newModel = (new StoreDictionary())::query()->create($insertInfo);
        if (!empty($newModel->getKey())) {
            return true;
        }
        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {

    }

    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StoreDictionary())::query()->where($closure)->first(["uuid", "title", "store_uuid",
            "group_uuid", "is_show", "created_at", "updated_at", "remark"]);
        if (!empty($bean)) {
            return $bean->toArray();
        }
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreDictionary())::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StoreDictionary())::query()->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StoreDictionary())::query()->whereIn($field, $deleteWhere)->delete();
    }
}