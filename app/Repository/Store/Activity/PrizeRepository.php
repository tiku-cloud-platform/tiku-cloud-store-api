<?php
declare(strict_types=1);

namespace App\Repository\Store\Activity;


use App\Model\Store\StoreActivityPrize;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 奖品信息
 * Class PrizeRepository
 * @package App\Repository\Store\Activity
 */
class PrizeRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreActivityPrize
     */
    protected $prizeModel;

    /**
     * @inheritDoc
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->prizeModel::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->where($closure)
            ->select($this->prizeModel->listSearchFields)
            ->paginate($perSize);

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
        if ($this->prizeModel::query()->create($insertInfo)) return true;
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
        $items = $this->prizeModel::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->where($closure)
            ->select($this->prizeModel->listSearchFields)
            ->first();

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
    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return $this->prizeModel::query()->where($updateWhere)->update($updateInfo);
    }

    /**
     * @inheritDoc
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return $this->prizeModel::query()->where($deleteWhere)->delete();
    }

    /**
     * @inheritDoc
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return $this->prizeModel::query()->whereIn($field, $deleteWhere)->delete();
    }
}