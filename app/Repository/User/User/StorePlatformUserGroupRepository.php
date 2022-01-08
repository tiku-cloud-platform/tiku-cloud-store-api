<?php
declare(strict_types=1);

namespace App\Repository\User\User;

use App\Model\User\StorePlatformUserGroup;
use App\Repository\UserRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 商户平台用户分组
 *
 * Class StorePlatformUserGroupRepository
 * @package App\Repository\User\User
 */
class StorePlatformUserGroupRepository implements UserRepositoryInterface
{
    /**
     * @Inject()
     * @var StorePlatformUserGroup
     */
    protected $groupModel;

    /**
     * @inheritDoc
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->groupModel::query()->where($closure)
            ->select($this->groupModel->searchFields)
            ->where([['is_show', '=', 1]])
            ->orderByDesc('id')
            ->paginate((int)$perSize);

        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size'  => $items->perPage(),
            'page'  => $items->currentPage(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        // TODO: Implement repositoryCreate() method.
    }

    /**
     * @inheritDoc
     */
    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    /**
     * @inheritDoc
     */
    public function repositoryFind(\Closure $closure): array
    {
        $bean = $this->groupModel::query()
            ->where($closure)
            ->select($this->groupModel->searchFields)
            ->first();

        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    /**
     * @inheritDoc
     */
    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        // TODO: Implement repositoryUpdate() method.
    }

    /**
     * @inheritDoc
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        // TODO: Implement repositoryDelete() method.
    }

    /**
     * @inheritDoc
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        // TODO: Implement repositoryWhereInDelete() method.
    }
}