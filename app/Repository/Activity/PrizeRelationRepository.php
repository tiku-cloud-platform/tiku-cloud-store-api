<?php
declare(strict_types=1);

namespace App\Repository\Activity;


use App\Model\Store\StoreActivityPrizeRelation;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 活动奖品关联
 * Class PrizeRelationRepository
 * @package App\Repository\Store\Activity
 */
class PrizeRelationRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreActivityPrizeRelation
     */
    protected $relationModel;

    /**
     * @inheritDoc
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        // TODO: Implement repositorySelect() method.
    }

    /**
     * @inheritDoc
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        if ($this->relationModel::query()->create($insertInfo)) return true;
        return false;
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
        // TODO: Implement repositoryFind() method.
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
        return $this->relationModel::query()->where($deleteWhere)->delete();
    }

    /**
     * @inheritDoc
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return $this->relationModel::query()->whereIn($field, $deleteWhere)->delete();
    }
}