<?php
declare(strict_types = 1);

namespace App\Repository\Store\User;

use App\Model\Store\StorePlatformUser;
use App\Model\Store\StorePlatformUserGroup;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户分组
 *
 * Class UserGroupRepository
 * @package App\Repository\Store\User
 */
class PlatformUserGroupRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StorePlatformUserGroup
     */
    protected $groupModel;

    public function __construct()
    {
    }

    /**
     * 查询数据
     *
     * @param \Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->groupModel::query()
            ->where($closure)
            ->select($this->groupModel->searchFields)
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
        if (!empty($this->groupModel::query()->create($insertInfo))) {
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
     * @param \Closure $closure
     * @return array
     * @author kert
     */
    public function repositoryFind(\Closure $closure): array
    {
        $bean = $this->groupModel::query()
            ->where($closure)
            ->first($this->groupModel->searchFields);

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
        return $this->groupModel::query()->where($updateWhere)->update($updateInfo);
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return $this->groupModel::query()->where($deleteWhere)->delete();
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
        return $this->groupModel::query()
            ->where('is_default', '=', 2)
            ->whereIn($field, $deleteWhere)
            ->delete();
    }

    /**
     * 绑定微信用户
     * @param array $userWhere 用户uuid
     * @param array $updateValue 更新值
     * @return int
     */
    public function repositoryBindUser(array $userWhere, array $updateValue)
    {
        return (new StorePlatformUser())::query()->whereIn('uuid', $userWhere)->update($updateValue);
    }
}