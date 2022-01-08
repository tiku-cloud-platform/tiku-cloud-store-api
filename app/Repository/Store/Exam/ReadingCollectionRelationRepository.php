<?php
declare(strict_types = 1);

namespace App\Repository\Store\Exam;

use App\Model\Store\StoreExamReadingCollectionRelation;
use App\Repository\StoreRepositoryInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 问答试卷关联
 *
 * Class ExamReadingCollectionRelationRepository
 * @package App\Repository\Store\Exam
 */
class ReadingCollectionRelationRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreExamReadingCollectionRelation
     */
    protected $relationModel;

    /**
     * 查询数据
     *
     * @param \Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        // TODO: Implement repositorySelect() method.
    }

    /**
     * 创建数据.
     *
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        return $this->relationModel->batchInsert((string)$this->relationModel->getTable(), (array)$insertInfo);
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
     * 查询数据
     *
     * @param \Closure $closure
     * @return array
     * @author kert
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
        // 筛选出哪些数据是新建，哪些数据是修改，哪些数据需要删除
        $relationInfo = $this->relationModel::query()->where('exam_uuid', '=', $updateWhere['exam_uuid'])->get(['id', 'exam_uuid', 'collection_uuid']);
        if (empty($relationInfo)) {
            return 1;
        }
        $relationInfo = $relationInfo->toArray();
        /** @var array $deleteArray 需要删除的关联数据 */
        $deleteArray = [];
        /** @var array $createArray 需要创建的关联数据 */
        $createArray = [];
        $idArray     = array_column($relationInfo, 'collection_uuid');

        foreach ($idArray as $value) {
            if (!in_array($value, $updateInfo)) {
                array_push($deleteArray, $value);
            }
        }

        foreach ($updateInfo as $value) {
            if (!in_array($value, $idArray)) {
                array_push($createArray, $value);
            }
        }

        $batchInfo = [];
        foreach ($createArray as $value) {
            $batchInfo[] = [
                'collection_uuid' => $value,
                'exam_uuid'       => $updateWhere['exam_uuid']
            ];
        }

        $returnVal = 0;

        Db::beginTransaction();
        try {
            if (!empty($deleteArray)) {
                $this->relationModel::query()->where([['exam_uuid', '=', $updateWhere['exam_uuid']]])
                    ->whereIn('collection_uuid', $deleteArray)->delete();
            }
            if (!empty($batchInfo)) {
                $this->relationModel->batchInsert((string)$this->relationModel->getTable(), (array)$batchInfo);
            }

            $returnVal = 1;
            DB::commit();;

        } catch (\Throwable $throwable) {
            var_dump($throwable->getMessage());
            Db::rollBack();
        }

        return $returnVal;
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
        return $this->relationModel::query()->whereIn($field, $deleteWhere)->delete();
    }
}