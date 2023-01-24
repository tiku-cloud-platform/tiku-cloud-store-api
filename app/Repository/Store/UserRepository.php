<?php
declare(strict_types = 1);

namespace App\Repository\Store;

use App\Model\Store\StoreUser;
use App\Repository\StoreRepositoryInterface;
use Closure;

/**
 * 商户端用户
 * Class UserRepository
 */
class UserRepository implements StoreRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {
    }

    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StoreUser)::query()
            ->where([['is_forbidden', '=', 1],])
            ->where($closure)
            ->first([
                "id",
                'uuid',
                'name',
                'email',
                'password',
                'login_number',
                'mobile',
                'expire_time',
                'avatar',
                'store_uuid',
                'remember_token',
                'company_name',
                'company_tel']);

        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreUser)::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return 0;
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return 0;
    }
}
