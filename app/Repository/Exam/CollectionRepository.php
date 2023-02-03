<?php
declare(strict_types = 1);

namespace App\Repository\Exam;


use App\Model\Store\StoreExamCollection;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 试卷
 *
 * Class CollectionRepository
 * @package App\Repository\Store\Exam
 */
class CollectionRepository implements StoreRepositoryInterface
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
        $items = (new StoreExamCollection)::query()
            ->with([
                'coverFileInfo:uuid,file_name,file_url',
                'examCategoryInfo:uuid,title'
            ])->with(['creator:id,name'])->where($closure)
            ->select([
                'uuid',
                'title',
                'is_show',
                'file_uuid',
                'orders',
                'is_recommend',
                'submit_number',
                'exam_category_uuid',
                'exam_time',
                'level',
                'author',
                'audit_author',
                "max_option_total",
                "max_judge_total",
                "max_reading_total",
                "resource_url",
                "create_id",
                "created_at",
                "exam_year",
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
     * 查询数据
     *
     * @param \Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositoryRelationSelect(\Closure $closure, int $perSize): array
    {
        $items = (new StoreExamCollection)::query()
            ->where($closure)
            ->select(['uuid', 'title'])
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
        if ((new StoreExamCollection)::query()->create(($insertInfo))) return true;
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
        $bean = (new StoreExamCollection)::query()
            ->with([
                'coverFileInfo:uuid,file_name,file_url',
                'examCategoryInfo:uuid,title'
            ])
            ->with(['creator:id,name'])
            ->where($closure)
            ->first([
                'uuid',
                'title',
                'is_show',
                'file_uuid',
                'orders',
                'is_recommend',
                'submit_number',
                'exam_category_uuid',
                'exam_time',
                'content',
                'level',
                'author',
                'audit_author',
                "max_option_total",
                "max_judge_total",
                "max_reading_total",
                "resource_url",
                "create_id",
                "created_at",
                "exam_year",
            ]);

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
        return (new StoreExamCollection)::query()->where($updateWhere)->update($updateInfo);
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StoreExamCollection)::query()->where($deleteWhere)->delete();
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
        return (new StoreExamCollection)::query()->whereIn($field, $deleteWhere)->delete();
    }

    /**
     * 查询某个字段之和
     *
     * @param \Closure $closure
     * @param string $field 查询字段
     * @return int
     */
    public function repositorySum(\Closure $closure, string $field): int
    {
        $sum = (new StoreExamCollection)::query()->where($closure)->sum($field);

        return empty($sum) ? 0 : (int)$sum;
    }

    /**
     * 查询总数据
     *
     * @param \Closure $closure
     * @return int
     */
    public function repositoryCount(\Closure $closure): int
    {
        return (new StoreExamCollection)::query()->where($closure)->count();
    }
}