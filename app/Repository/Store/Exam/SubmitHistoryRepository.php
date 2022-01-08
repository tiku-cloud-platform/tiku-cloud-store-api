<?php

namespace App\Repository\Store\Exam;

use App\Model\Store\StoreExamSubmitHistory;
use App\Repository\StoreRepositoryInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 试题提交历史
 *
 * class SubmitHistoryRepository
 * @package App\Repository\Store\Exam
 */
class SubmitHistoryRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreExamSubmitHistory
     */
    protected $historyModel;

    public function __construct()
    {
    }

    /**
     * 查询数据
     *
     * @param \Closure $closure
     * @param int $perSize 分页大小 exam_collection_uuid
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->historyModel::query()
            ->with(['collection:uuid,title,file_uuid,exam_time,exam_category_uuid'])
            ->where($closure)
            ->select(['uuid', 'created_at', 'exam_collection_uuid', Db::raw("sum(score) as score"), 'submit_time'])
            ->groupBy(['exam_collection_uuid'])
            ->paginate($perSize);

        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size'  => $items->perPage(),
            'page'  => $items->currentPage(),
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
        return true;
    }

    /**
     * 添加数据
     *
     * @param array $addInfo 添加信息
     * @return int 添加之后的ID或者行数
     */
    public function repositoryAdd(array $addInfo): int
    {
        return 1;
    }

    /**
     * 查询数据
     *
     * @param \Closure $closure
     * @return array
     * @author kert
     */
    public function repositoryFind(\Closure $closure): array
    {
        $bean = $this->historyModel::query()
            ->with(['collection:uuid,title'])
            ->with(['user:uuid,title'])
            ->where($closure)
            ->first($this->historyModel->listSearchFields);

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
        return 1;
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return 1;
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
        return 1;
    }

    /**
     * 查询每日提交数量
     *
     * @param \Closure $closure
     * @return array
     */
    public function repositoryEveryDayCount(\Closure $closure): array
    {
        // SELECT DATE_FORMAT(created_at,'%Y-%m-%d') AS `date`,COUNT(*) AS `number` FROM `store_exam_submit_history` WHERE
        // (`created_at`>='2021-08-01 00:00:00' AND `created_at`<='2021-08-30 23:59:59') AND `store_exam_submit_history`.`deleted_at` IS NULL
        // AND `store_uuid`='35c28259-9b55-e438-3830-dfc79f592709' GROUP BY DATE_FORMAT(`created_at`,'%Y-%m-%d')
        $items = $this->historyModel::query()->where($closure)
            ->groupBy([Db::raw("DATE_FORMAT(`created_at`,'%Y-%m-%d')")])
            ->select([
                Db::raw("DATE_FORMAT(created_at,'%Y-%m-%d') AS `date`"),
                Db::raw("COUNT(*) AS `number`")
            ])->get();

        if (!empty($items)) return $items->toArray();
        return [];
    }

    /**
     * 查询答题总数
     *
     * @param string $date 日期
     * @return int
     */
    public function repositoryEveryDayTotal(string $date): int
    {
        return $this->historyModel::query()
            ->where('created_at', '<=', $date . ' 23:59:59')
            ->count();
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