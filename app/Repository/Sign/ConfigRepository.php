<?php
declare(strict_types = 1);

namespace App\Repository\Sign;

use App\Model\Store\StoreSignConfig;
use App\Repository\StoreRepositoryInterface;
use Closure;

/**
 * 签到配置
 */
class ConfigRepository implements StoreRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreSignConfig())::query()->where($closure)->paginate($perSize, [
            'uuid',
            'num',
            'score',
            'is_show',
            'store_uuid',
            'remark',
            "is_continue",
            "created_at",
        ]);
        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size' => $items->perPage(),
            'page' => $items->currentPage(),
        ];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        if (!empty((new StoreSignConfig)::query()->create($insertInfo))) {
            return true;
        }
        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {

    }

    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StoreSignConfig)::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->where($closure)
            ->first([
                'uuid',
                'num',
                'score',
                'is_show',
                'store_uuid',
                'remark',
                "is_continue",
                "created_at",
            ]);
        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreSignConfig)::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StoreSignConfig)::query()->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StoreSignConfig)::query()->whereIn($field, $deleteWhere)->delete();
    }
}