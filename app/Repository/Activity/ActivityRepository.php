<?php
declare(strict_types=1);

namespace App\Repository\Activity;


use App\Model\Store\StoreActivity;
use App\Repository\StoreRepositoryInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 活动基础信息
 * Class ActivityRepository
 * @package App\Repository\Store\Activity
 */
class ActivityRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreActivity
     */
    private $activityModel;

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
        $result = false;
        Db::transaction(function () use ($insertInfo, &$result) {
            // 1. 插入基础信息
            $insertActivityResult = $this->activityModel::query()->create($insertInfo['activity']);
            // 2. 插入活动图片数据
            $insertActivityImageResult = (new ActivityImageRepository())->repositoryCreate((array)['image']);

            if ($insertActivityImageResult && $insertActivityResult) $result = true;
        }, 2);

        return $result;
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
        return $this->activityModel::query()->where($deleteWhere)->delete();
    }

    /**
     * @inheritDoc
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return $this->activityModel::query()->whereIn($field, $deleteWhere)->delete();
    }
}