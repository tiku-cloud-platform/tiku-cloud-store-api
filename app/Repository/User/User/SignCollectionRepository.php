<?php
declare(strict_types=1);

namespace App\Repository\User\User;


use App\Mapping\UUID;
use App\Model\User\StoreUserSignCollection;
use App\Repository\UserRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户签到汇总
 *
 * Class SignCollectionRepository
 * @package App\Repository\User\User
 */
class SignCollectionRepository implements UserRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreUserSignCollection
     */
    protected $signCollectionModel;

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
        // TODO: Implement repositorySelect() method.
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
     */
    public function repositoryFind(\Closure $closure): array
    {
        $bean = $this->signCollectionModel::query()
            ->where($closure)
            ->select($this->signCollectionModel->searchFields)
            ->first();

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
        $bean = $this->signCollectionModel::query()->where('user_uuid', '=', $updateWhere['user_uuid'])->first(['uuid']);
        if (empty($bean)) {
            // 不存在记录
            if ($this->signCollectionModel::query()->create([
                'uuid'        => UUID::getUUID(),
                'user_uuid'   => $updateWhere['user_uuid'],
                'sign_number' => 1,
                'store_uuid'  => $updateWhere['store_uuid'],
                'is_show'     => 1,
            ])) {
                return 0;
            }
            return 1;
        } else {
            // 存在记录
            return $this->signCollectionModel::query()->where($updateWhere)->update($updateInfo);
        }
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
     * 增加签到字段值
     *
     * @param array $updateWhere 更新条件
     * @return int
     */
    public function repositoryIncry(array $updateWhere): int
    {
        return $this->signCollectionModel->fieldIncr((string)$this->signCollectionModel->getTable(), (array)$updateWhere,
            (string)'sign_number', (int)1);
    }
}