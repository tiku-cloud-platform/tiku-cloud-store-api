<?php
declare(strict_types = 1);

namespace App\Repository\Store\Exam;


use App\Model\Store\StoreExamOptionItem;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 单选试题选项
 *
 * Class OptionItemRepository
 * @package App\Repository\Store\Exam
 */
class OptionItemRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreExamOptionItem
     */
    protected $optionItemModel;

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
        // TODO: Implement repositorySelect() method.
    }

    /**
     * 创建数据.
     *
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        return $this->optionItemModel->batchInsert((string)$this->optionItemModel->getTable(),
            (array)$insertInfo['option'],
            (string)'option_uuid',
            (string)$insertInfo['option_uuid']
        );
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
        // TODO: Implement repositoryFind() method.
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
        $updateResult = $this->optionItemModel->batchUpdateOrCreate(
            (string)$this->optionItemModel->getTable(),
            (array)$updateInfo,
            (string)'option_uuid',
            (string)$updateWhere[0][2]);

        return $updateResult ? 1 : 0;
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