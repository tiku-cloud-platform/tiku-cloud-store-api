<?php
declare(strict_types = 1);

namespace App\Repository\User\User;


use App\Model\User\StoreExamSubmitHistory;
use App\Repository\User\Exam\CollectionRepository;
use App\Repository\UserRepositoryInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 试题提交记录
 *
 * Class ExamSubmitHistoryRepository
 * @package App\Repository\User\User
 */
class ExamSubmitHistoryRepository implements UserRepositoryInterface
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
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->historyModel::query()
            ->with(['collection:uuid,title,file_uuid'])
            ->where($closure)
            ->select(['uuid', 'exam_collection_uuid', Db::raw("sum(score) as score"), 'submit_time'])
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
     * 创建数据
     *
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        $score      = $insertInfo['score'];
        $insertInfo = $insertInfo['exam'];
        var_dump($score);

        $result = false;
        Db::transaction(function () use (&$result, $insertInfo, $score) {
            // 清空之前该试卷的记录
            $this->historyModel::where([
                ['exam_collection_uuid', '=', $insertInfo[0]['exam_collection_uuid']],
                ['user_uuid', '=', $insertInfo[0]['user_uuid']],
            ])->delete();

            // 插入记录
            $this->historyModel->batchInsert((string)$this->historyModel->getTable(), (array)$insertInfo, (string)'',
                (string)'', (string)'user');

            // 增加试卷答题数量
            (new CollectionRepository())->repositoryIncrField((array)[
                ['uuid', '=', $insertInfo[0]['exam_collection_uuid']]
            ]);

            // 增加积分记录
            (new ScoreHistoryRepository())->repositoryCreate((array)$score);

            $result = true;
        });

        return $result;
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
     * @param \Closure $closure
     * @return array
     */
    public function repositoryFind(\Closure $closure): array
    {
        // TODO: Implement repositoryFind() method.
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
     * 统计总条数
     *
     * @param \Closure $closure
     * @return int
     */
    public function repositoryCountGroup(\Closure $closure): int
    {
        return $this->historyModel::query()->where($closure)->count('uuid');
    }
}