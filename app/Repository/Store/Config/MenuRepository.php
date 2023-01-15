<?php
declare(strict_types = 1);

namespace App\Repository\Store\Config;

use App\Model\Store\StoreMenu;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户端菜单配置
 * Class MenuRepository
 * @package App\Repository\Store\Config
 */
class MenuRepository implements StoreRepositoryInterface
{
    /**
     * 查询数据
     * @param Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreMenu)::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->with(['client:title,uuid'])
            ->with(['position:title,uuid'])
            ->where($closure)
            ->select((new StoreMenu)->searchFields)
            ->orderByDesc('orders')
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
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        if (!empty((new StoreMenu)::query()->create($insertInfo))) {
            return true;
        }

        return false;
    }

    /**
     * 添加数据
     * @param array $addInfo 添加信息
     * @return int 添加之后的ID或者行数
     */
    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    /**
     * 单条数据查询
     * @param Closure $closure
     * @return array
     * @author kert
     */
    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StoreMenu)::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->with(['client:title,uuid'])
            ->with(['position:title,uuid'])
            ->where($closure)
            ->first((new StoreMenu)->searchFields);

        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    /**
     * 更新数据
     * @param array $updateWhere 修改条件
     * @param array $updateInfo 修改信息
     * @return int 更新行数
     */
    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreMenu)::query()->where($updateWhere)->update($updateInfo);
    }

    /**
     * 删除数据
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StoreMenu)::query()->where($deleteWhere)->delete();
    }

    /**
     * 范围删除
     * @param array $deleteWhere 删除条件
     * @param string $field 删除字段
     * @return int
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return (new StoreMenu)::query()->whereIn($field, $deleteWhere)->delete();
    }
}