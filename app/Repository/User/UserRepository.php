<?php
declare(strict_types = 1);

namespace App\Repository\User;

use App\Model\Store\StorePlatformUser;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Hyperf\DbConnection\Db;

/**
 * 平台用户
 */
class UserRepository implements StoreRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StorePlatformUser)::query()
            ->with(['group:uuid,title'])
            ->with(['channel:uuid,title'])
            ->where($closure)
            ->select(['uuid',
                'real_name',
                'mobile',
                'created_at',
                'updated_at',
                'store_platform_user_group_uuid',
                'channel_uuid',
                "age",
                "birthday",
                "remark",
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
        if (!empty((new StorePlatformUser)::query()->create($insertInfo))) {
            return true;
        }
        return false;
    }

    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StorePlatformUser)::query()
            ->with(['group:uuid,title'])
            ->where($closure)
            ->first([
                'real_name',
                'mobile',
                'created_at',
                'updated_at',
                'store_platform_user_group_uuid',
                'channel_uuid',
                "age",
                "birthday",
                "remark",
            ]);

        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    public function repositoryAllFind(Closure $closure): array
    {
        $bean = (new StorePlatformUser)::query()
            ->with(['group:uuid,title'])
            ->with(['score:uuid,score,user_uuid'])
            ->where($closure)
            ->first([
                "id",
                "uuid",
                'real_name',
                'mobile',
                "created_at",
                'updated_at',
                'store_platform_user_group_uuid',
                'channel_uuid',
                "age",
                "birthday",
                "remark",
                "gender",
            ]);

        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StorePlatformUser)::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StorePlatformUser)::query()->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StorePlatformUser)::query()->whereIn($field, $deleteWhere)->delete();
    }

    public function repositoryCount(Closure $closure): int
    {
        return (new StorePlatformUser)::query()->where($closure)->count();
    }

    public function repositoryAdd(array $addInfo): int
    {

    }
}