<?php
declare(strict_types = 1);

namespace App\Repository\Score;


use App\Model\Store\StoreUserScoreHistory;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户积分历史
 *
 * Class ScoreHistoryRepository
 * @package App\Repository\Store\Score
 */
class ScoreHistoryRepository implements StoreRepositoryInterface
{
    /**
     * 查询数据
     *
     * @param \Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = (new StoreUserScoreHistory)::query()
            ->with(['user:uuid,real_name'])
            ->where($closure)
            ->select([
                "title",
                "client_type",
                "type",
                "score",
                "created_at",
                "user_uuid",
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

    /**
     * 创建数据.
     *
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo): bool
    {

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
     *
     * @param \Closure $closure
     * @return array
     * @author kert
     */
    public function repositoryFind(\Closure $closure): array
    {

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
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
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
            $searchFields[$value] = (new StoreUserScoreHistory)::query()->where($searchWhere)->sum($value);
        }

        return $searchFields;
    }
}