<?php
declare(strict_types = 1);

namespace App\Repository\Article;


use App\Model\Store\StoreArticle;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 文章管理
 *
 * Class ArticleRepository
 * @package App\Repository\Store\Article
 */
class ArticleRepository implements StoreRepositoryInterface
{
    /**
     * 查询数据
     *
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreArticle)::query()
            ->with(['categoryInfo:uuid,title'])
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->with(['creator:id,name'])
            ->where($closure)
            ->select([
                'uuid',
                'article_category_uuid',
                'title',
                'file_uuid',
                'content',
                'publish_date',
                'author',
                'source',
                'read_number',
                'orders',
                'is_show',
                'is_top',
                'is_publish',
                "read_score",
                "share_score",
                "click_score",
                "collection_score",
                "read_expend_score",
                "create_id",
                "created_at",
            ])
            ->orderByDesc("id")
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
        if (!empty((new StoreArticle)::query()->create($insertInfo))) {
            return true;
        }

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
     *
     * @param Closure $closure
     * @return array
     * @author kert
     */
    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StoreArticle)::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->with(['creator:id,name'])
            ->where($closure)
            ->first([
                'uuid',
                'article_category_uuid',
                'title',
                'file_uuid',
                'content',
                'publish_date',
                'author',
                'source',
                'read_number',
                'orders',
                'is_show',
                'is_top',
                'is_publish',
                "read_score",
                "share_score",
                "click_score",
                "collection_score",
                "read_expend_score",
                "create_id",
                "created_at",
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
        return (new StoreArticle)::query()->where($updateWhere)->update($updateInfo);
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StoreArticle)::query()->where($deleteWhere)->delete();
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
        return (new StoreArticle)::query()->whereIn($field, $deleteWhere)->delete();
    }

    /**
     * 范围更新
     *
     * @param array $updateWhere 更新条件
     * @param string $field 更新条件字段字
     * @param array $updateValue 更新值['字段1' => '值1', '字段2' => '值2', ..., '字段n' => '值n']
     * @return int
     */
    public function repositoryWhereInUpdate(array $updateWhere, string $field, array $updateValue): int
    {
        return (new StoreArticle)::query()->whereIn($field, $updateWhere)->update($updateValue);
    }
}