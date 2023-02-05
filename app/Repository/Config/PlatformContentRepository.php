<?php
declare(strict_types = 1);

namespace App\Repository\Config;


use App\Model\Store\StorePlatformContent;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台内容介绍
 *
 * Class PlatformContentRepository
 * @package App\Repository\Store\Config
 */
class PlatformContentRepository implements StoreRepositoryInterface
{
    /**
     * 查询数据
     * @param Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StorePlatformContent)::query()
            ->with(['creator:id,name'])
            ->where($closure)
            ->select([
                'uuid',
                'is_show',
                'title',
                'orders',
                "create_id",
                "created_at",
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
        if (!empty((new StorePlatformContent)::query()->create($insertInfo))) {
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
        $bean = (new StorePlatformContent)::query()
            ->with(['creator:id,name'])
            ->where($closure)
            ->first([
                'uuid',
                'content',
                'is_show',
                'title',
                'orders',
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
        return (new StorePlatformContent)::query()->where($updateWhere)->update($updateInfo);
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StorePlatformContent)::query()->where($deleteWhere)->delete();
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
        return (new StorePlatformContent)::query()->whereIn($field, $deleteWhere)->delete();
    }
}