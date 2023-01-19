<?php
declare(strict_types = 1);

namespace App\Repository\Exam;


use App\Model\Store\StoreExamTag;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 试题知识点
 *
 * Class TagRepository
 * @package App\Repository\Store\Exam
 */
class TagRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreExamTag
     */
    protected $tagModel;

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
        $items = $this->tagModel::query()
            ->with(['children:title,uuid,parent_uuid,remark,is_show,orders'])
            ->where($closure)
            ->whereNull('parent_uuid')
            ->select($this->tagModel->searchFields)
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
     * 查询顶级分类
     *
     * @param \Closure $closure
     * @param int $perSize
     * @return array
     */
    public function repositoryParentSelect(\Closure $closure, int $perSize): array
    {
        $items = $this->tagModel::query()
            ->where($closure)
            ->whereNull('parent_uuid')
            ->select($this->tagModel->searchFields)
            ->orderByDesc('id')
            ->paginate((int)$perSize);

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
        if ($this->tagModel::query()->create(($insertInfo))) return true;
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
     * 查询数据
     *
     * @param \Closure $closure
     * @return array
     * @author kert
     */
    public function repositoryFind(\Closure $closure): array
    {
        $bean = $this->tagModel::query()
            ->where($closure)
            ->first($this->tagModel->searchFields);

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
        return $this->tagModel::query()->where($updateWhere)->update($updateInfo);
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return $this->tagModel::query()->where($deleteWhere)->delete();
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
        return $this->tagModel::query()->whereIn($field, $deleteWhere)->delete();
    }
}