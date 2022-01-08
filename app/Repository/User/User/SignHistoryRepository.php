<?php
declare(strict_types = 1);

namespace App\Repository\User\User;


use App\Model\User\StoreUserSignHistory;
use App\Repository\UserRepositoryInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户签到历史
 *
 * Class SignHistoryRepository
 * @package App\Repository\User\User
 */
class SignHistoryRepository implements UserRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreUserSignHistory
     */
    protected $signHistoryModel;

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
        /** @var object $self */
        $signHistoryRepository    = new SignHistoryRepository();
        $signCollectionRepository = new SignCollectionRepository();
        $scoreRepository          = new ScoreHistoryRepository();

        $returnVal = false;

        if (empty($insertInfo['yesterdayInfo'])) {// 重置签到天数
            Db::transaction(function () use ($insertInfo, $signCollectionRepository, $signHistoryRepository, &$returnVal, $scoreRepository) {
                $signHistoryRepository->signHistoryModel::query()->create($insertInfo['history']);
                $signCollectionRepository->repositoryUpdate((array)[
                    'user_uuid'  => $insertInfo['history']['user_uuid'],
                    'store_uuid' => $insertInfo['history']['store_uuid'],
                ], (array)['sign_number' => 1]);
                if (!empty($insertInfo['score'])) {
                    $scoreRepository->repositoryCreate((array)$insertInfo['score']);
                }
                $returnVal = true;
            });
        } else {// 累计签到天数
            Db::transaction(function () use ($insertInfo, $signCollectionRepository, $signHistoryRepository, &$returnVal, $scoreRepository) {
                $signHistoryRepository->signHistoryModel::query()->create($insertInfo['history']);
                $signCollectionRepository->repositoryIncry((array)[
                    'user_uuid'  => $insertInfo['history']['user_uuid'],
                    'store_uuid' => $insertInfo['history']['store_uuid']
                ]);
                if (!empty($insertInfo['score'])) {
                    $scoreRepository->repositoryCreate((array)$insertInfo['score']);
                }

                $returnVal = false;
            });
        }

        return $returnVal;
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
        $bean = $this->signHistoryModel::query()
            ->where($closure)
            ->select($this->signHistoryModel->searchFields)
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
        // TODO: Implement repositoryUpdate() method.
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
}