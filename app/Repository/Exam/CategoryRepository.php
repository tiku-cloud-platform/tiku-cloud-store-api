<?php
declare(strict_types = 1);

namespace App\Repository\Exam;


use App\Model\Store\StoreExamCategory;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 试题分类
 *
 * Class CategoryRepository
 * @package App\Repository\Store\Exam
 */
class CategoryRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreExamCategory
     */
    protected $categoryModel;

    /**
     * 查询数据
     *
     * @param \Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->categoryModel::query()
            ->with(['smallFileInfo:uuid,file_name,file_url'])
            ->with(['bigFileInfo:uuid,file_name,file_url'])
            ->with(['children:uuid,title,parent_uuid,remark,is_show,file_uuid,big_file_uuid,orders,is_recommend'])
            ->where($closure)
            ->whereNull('parent_uuid')
            ->select($this->categoryModel->searchFields)
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
     * 用于api端查询
     * @param array $searchWhere
     * @param int $perSize
     * @return array
     */
    public function repositoryAllSelect(array $searchWhere, int $perSize): array
    {
        $items = $this->categoryModel::query()
            ->with(['allChildren:uuid,title,parent_uuid,file_uuid,big_file_uuid'])
            ->where($searchWhere)
            ->whereNull('parent_uuid')
            ->select(['uuid', 'title', 'parent_uuid', 'file_uuid', 'big_file_uuid'])
            ->orderByDesc('orders')
            ->paginate($perSize);

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
        $items = $this->categoryModel::query()
            ->with(['smallFileInfo:uuid,file_name,file_url'])
            ->with(['bigFileInfo:uuid,file_name,file_url'])
            ->where($closure)
            ->whereNull('parent_uuid')
            ->select($this->categoryModel->searchFields)
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
     * 创建数据.
     *
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        if ($this->categoryModel::query()->create(($insertInfo))) return true;
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
        $bean = $this->categoryModel::query()
            ->with(['smallFileInfo:uuid,file_name,file_url'])
            ->with(['bigFileInfo:uuid,file_name,file_url'])
            ->where($closure)
            ->first($this->categoryModel->searchFields);

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
        return $this->categoryModel::query()->where($updateWhere)->update($updateInfo);
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return $this->categoryModel::query()->where($deleteWhere)->delete();
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
        return $this->categoryModel::query()->whereIn($field, $deleteWhere)->delete();
    }

    /**
     * 查询二级类型
     * @param \Closure $closure
     * @param int $perSize
     * @return array
     */
    public function repositorySecond(\Closure $closure, int $perSize = 20): array
    {
        $items = $this->categoryModel::query()
            ->where($closure)
            ->whereNotNull('parent_uuid')
            ->select(['uuid', 'title'])
            ->orderByDesc('id')
            ->paginate((int)$perSize);

        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size'  => $items->perPage(),
            'page'  => $items->currentPage(),
        ];
    }
}