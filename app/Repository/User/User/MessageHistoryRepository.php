<?php
declare(strict_types=1);

namespace App\Repository\User\User;


use App\Model\User\StorePlatformMessageHistory;
use App\Repository\UserRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台消息阅读历史
 *
 * Class MessageHistoryRepository
 * @package App\Repository\User\User
 */
class MessageHistoryRepository implements UserRepositoryInterface
{
	/**
	 * @Inject()
	 * @var StorePlatformMessageHistory
	 */
	protected $historyModel;

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
		try {
			if ($this->historyModel::query()->create($insertInfo)) {
				return true;
			}
		} catch (\Throwable $throwable) {
			// TODO 记录错误日志信息
			return false;
//			throw  new DbDataMessageException($throwable->getMessage());
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
	 */
	public function repositoryFind(\Closure $closure): array
	{
		$bean = $this->historyModel::query()
			->where($closure)
			->select($this->historyModel->searchFields)
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

	/**
	 * 查询总数
	 *
	 * @param array $searchWhere 查询条件
	 * @return int
	 */
	public function repositoryCount(array $searchWhere = []): int
	{
		return $this->historyModel::query()->where($searchWhere)->count('id');
	}
}