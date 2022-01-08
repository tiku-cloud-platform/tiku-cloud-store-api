<?php
declare(strict_types = 1);

namespace App\Repository\User\User;


use App\Model\User\StoreUserScoreHistory;
use App\Repository\UserRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户积分历史
 *
 * Class ScoreHistoryRepository
 * @package App\Repository\User\User
 */
class ScoreHistoryRepository implements UserRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreUserScoreHistory
     */
    protected $historyModel;

    public function __construct()
    {
    }

    /**
     * 查询数据
     *
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->historyModel::query()->where($closure)
            ->select($this->historyModel->searchFields)
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
     * 创建数据
     *
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        if ($this->historyModel::query()->create($insertInfo)) return true;
        return false;
    }

    /**
     * 添加数据
     *
     * @param array $addInfo 添加信息
     * @return int 添加之后的ID或者行数
     */
    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    /**
     * 单条数据查询
     */
    public function repositoryFind(\Closure $closure): array
    {
        $bean = $this->historyModel::query()
            ->where($closure)
            ->select($this->historyModel->searchFields)
            ->first();

        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    /**
     * 更新数据
     *
     * @param array $updateWhere 修改条件
     * @param array $updateInfo 修改信息
     * @return int 更新行数
     */
    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        // TODO: Implement repositoryUpdate() method.
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        // TODO: Implement repositoryDelete() method.
    }

    /**
     * 范围删除
     *
     * @param array $deleteWhere 删除条件
     * @param string $field 删除字段
     * @return int
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        // TODO: Implement repositoryWhereInDelete() method.
    }

    /**
     * 查询数据总数
     *
     * @param array $searchWhere
     * @param array $searchFields
     * @return array
     */
    public function repositorySum(array $searchWhere, array $searchFields): array
    {
        foreach ($searchFields as $value) {
            $searchFields[$value] = $this->historyModel::query()->where($searchWhere)->sum($value);
        }

        return $searchFields;
    }
}