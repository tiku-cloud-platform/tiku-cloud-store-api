<?php
declare(strict_types = 1);

namespace App\Repository\Store\Exam;

use App\Model\Store\StoreExamCollectionRelation;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 试题试卷关联
 *
 * Class CollectionRelationRepository
 * @package App\Repository\Store\Exam
 */
class CollectionRelationRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreExamCollectionRelation
     */
    protected $relationModel;

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
        return $this->relationModel::query()->whereIn($field, $deleteWhere)->delete();
    }

    /**
     * 查询总数
     *
     * @param string $field 查询字段
     * @param array $values 字段值
     * @return int 总和
     */
    public function repositoryWhereInCount(string $field, array $values):int
    {
        return  $this->relationModel::query()->whereIn($field, $values)->count("id");
    }
}