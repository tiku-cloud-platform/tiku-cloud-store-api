<?php
declare(strict_types = 1);

namespace App\Repository\User\Exam;


use App\Model\User\StoreExamCollection;
use App\Repository\UserRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 试卷
 *
 * Class CollectionRepository
 * @package App\Repository\User\Exam
 */
class CollectionRepository implements UserRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreExamCollection
     */
    protected $collectionModel;

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
        $items = $this->collectionModel::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->with(['examCategoryInfo:uuid,title'])
            ->where([['is_show', '=', 1]])
            ->where($closure)
            ->select(['uuid', 'title', 'file_uuid', 'submit_number', 'author', 'exam_category_uuid'])
            ->orderByDesc('orders')
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
        // TODO: Implement repositoryCreate() method.
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
        $bean = $this->collectionModel::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->where([['is_show', '=', 1]])
            ->where($closure)
            ->first(['uuid', 'title', 'file_uuid', 'submit_number', 'author', 'audit_author', 'level', 'content', 'exam_time']);
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
     * 增加某一个字段值
     *
     * @param array $incrWhere 修改条件
     * @param string $field 修改字段
     * @param int $incrValue 增加值
     * @return int
     */
    public function repositoryIncrField(array $incrWhere, string $field = 'submit_number', int $incrValue = 1)
    {
        return $this->collectionModel::query()->where($incrWhere)->increment($field, $incrValue);
    }
}