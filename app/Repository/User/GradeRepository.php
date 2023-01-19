<?php
declare(strict_types = 1);

namespace App\Repository\User;

use App\Model\Store\StorePlatformUser;
use App\Model\Store\StorePlatformUserGroup;
use App\Repository\StoreRepositoryInterface;
use Closure;

/**
 * 会员等级
 * Class GradeRepository
 * @package App\Repository\Store\User
 */
class GradeRepository implements StoreRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StorePlatformUserGroup)::query()
            ->with(["icon:uuid,file_url,file_name"])
            ->where($closure)
            ->select((new StorePlatformUserGroup)->searchFields)
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
        if (!empty((new StorePlatformUserGroup)::query()->create($insertInfo))) {
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
        $bean = (new StorePlatformUserGroup)::query()
            ->with(["icon:uuid,file_url,file_name"])
            ->where($closure)
            ->first((new StorePlatformUserGroup)->searchFields);

        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StorePlatformUserGroup)::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StorePlatformUserGroup)::query()->where($deleteWhere)->delete();
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StorePlatformUserGroup)::query()
            ->where('is_default', '=', 2)
            ->whereIn($field, $deleteWhere)
            ->delete();
    }

    public function repositoryBindUser(array $userWhere, array $updateValue)
    {
        return (new StorePlatformUser())::query()->whereIn('uuid', $userWhere)->update($updateValue);
    }
}