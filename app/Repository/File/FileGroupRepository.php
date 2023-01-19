<?php

declare(strict_types = 1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Repository\File;

use App\Model\Store\StorePlatformFileGroup;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台文件组配置.
 *
 * Class FileGroupRepository
 */
class FileGroupRepository implements StoreRepositoryInterface
{
    /**
     * @Inject
     * @var StorePlatformFileGroup
     */
    protected $fileGroupMode;

    public function __construct()
    {
    }

    /**
     * 查询数据.
     *
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->fileGroupMode::query()
            ->with(['children:parent_uuid,uuid,title,is_show'])
            ->where($closure)
            ->whereNull('parent_uuid')
            ->select($this->fileGroupMode->searchFields)
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
        $items = $this->fileGroupMode::query()
            ->where($closure)
            ->whereNull('parent_uuid')
            ->select($this->fileGroupMode->searchFields)
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
        if (!empty($this->fileGroupMode::query()->create($insertInfo))) {
            return true;
        }

        return false;
    }

    /**
     * 添加数据.
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
     * @param \Closure $closure
     * @return array
     * @author kert
     */
    public function repositoryFind(\Closure $closure): array
    {
        $bean = $this->fileGroupMode::query()->where($closure)->first($this->fileGroupMode->searchFields);

        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    /**
     * 更新数据.
     *
     * @param array $updateWhere 修改条件
     * @param array $updateInfo 修改信息
     * @return int 更新行数
     */
    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return $this->fileGroupMode::query()->where($updateWhere)->update($updateInfo);
    }

    /**
     * 删除数据.
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return $this->fileGroupMode::query()->where($deleteWhere)->delete();
    }

    /**
     * 范围删除.
     *
     * @param array $deleteWhere 删除条件
     * @param string $field 删除字段
     * @return int
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return $this->fileGroupMode::query()->whereIn($field, $deleteWhere)->delete();
    }

    /**
     * 查询全部数据
     *
     * @param array $searchWhere 查询条件[一维数组]
     * @param string $field 查询字段
     * @return array
     */
    public function repositoryAllIn(array $searchWhere, string $field): array
    {
        $items = $this->fileGroupMode::query()->whereIn($field, $searchWhere)->get($this->fileGroupMode->searchFields);

        if (!empty($items)) return $items->toArray();
        return [];
    }
}
