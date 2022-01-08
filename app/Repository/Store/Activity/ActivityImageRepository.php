<?php
declare(strict_types=1);

namespace App\Repository\Store\Activity;


use App\Model\Store\StoreActivityImage;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 活动图片
 * Class ActivityImageRepository
 * @package App\Repository\Store\Activity
 */
class ActivityImageRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreActivityImage
     */
    protected $imageMode;

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
        if ($this->imageMode::query()->create($insertInfo)) return true;
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
        return $this->imageMode::query()->where($deleteWhere)->delete();
    }

    /**
     * @inheritDoc
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return $this->imageMode::query()->whereIn($field, $deleteWhere)->delete();
    }
}