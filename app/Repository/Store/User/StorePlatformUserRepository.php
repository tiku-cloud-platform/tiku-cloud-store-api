<?php
declare(strict_types = 1);

namespace App\Repository\Store\User;


use App\Model\Store\StorePlatformUser;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 微信用户
 * Class StorePlatformUserRepository
 * @package App\Repository\Store\User
 */
class StorePlatformUserRepository implements StoreRepositoryInterface
{
    /**
     * 查询数据
     *
     * @param Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StorePlatformUser)::query()
            ->with(['group:uuid,title'])
            ->with(['channel:uuid,title'])
            ->where($closure)
            ->select((new StorePlatformUser)->searchFields)
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
        if (!empty((new StorePlatformUser)::query()->create($insertInfo))) {
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
        $bean = (new StorePlatformUser)::query()
            ->with(['group:uuid,title'])
            ->where($closure)
            ->first((new StorePlatformUser)->searchFields);

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
        return (new StorePlatformUser)::query()->where($updateWhere)->update($updateInfo);
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return (new StorePlatformUser)::query()->where($deleteWhere)->delete();
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
        return (new StorePlatformUser)::query()->whereIn($field, $deleteWhere)->delete();
    }

    /**
     * 查询总数据
     *
     * @param Closure $closure
     * @return int
     */
    public function repositoryCount(Closure $closure): int
    {
        return (new StorePlatformUser)::query()->where($closure)->count();
    }

    /**
     * 查询每日注册用户
     *
     * @param Closure $closure
     * @return array
     */
    public function repositoryEveryDayCount(Closure $closure): array
    {
        // SELECT DATE_FORMAT(created_at,'%Y-%m-%d') AS `current_date`,COUNT(*) AS `register_count` FROM store_wechat_user
        //WHERE created_at BETWEEN '2021-08-01 00:00:00' AND '2021-08-31 23:59:59' GROUP BY DATE_FORMAT(created_at,'%Y-%m-%d');

        $items = (new StorePlatformUser)::query()->where($closure)
            ->groupBy([Db::raw("DATE_FORMAT(`created_at`,'%Y-%m-%d')")])
            ->select([
                Db::raw("DATE_FORMAT(created_at,'%Y-%m-%d') AS `date`"),
                Db::raw("COUNT(*) AS `number`")
            ])->get();

        if (!empty($items)) {
            return $items->toArray();
        }
        return [];
    }

    /**
     * 查询每日用户总数
     *
     * @param string $date 日期
     * @return int
     */
    public function repositoryEveryDayTotal(string $date): int
    {
        return (new StorePlatformUser)::query()
            ->where('created_at', '<=', $date . ' 23:59:59')
            ->count();
    }

}