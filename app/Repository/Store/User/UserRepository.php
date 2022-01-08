<?php

declare(strict_types=1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Repository\Store\User;

use App\Model\Store\StoreUser;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 商户端用户.
 *
 * Class UserRepository
 */
class UserRepository implements StoreRepositoryInterface
{
	/**
	 * @Inject
	 * @var StoreUser
	 */
	protected $storeUserModel;

	public function __construct()
	{
	}

	/**
	 * 查询数据.
	 *
	 * @param int $perSize 分页大小
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
		// TODO: Implement repositoryCreate() method.
	}

	/**
	 * 添加数据.
	 *
	 * @param array $addInfo 添加信息
	 * @return int 添加之后的ID或者行数
	 */
	public function repositoryAdd(array $addInfo): int
	{
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
		$bean = $this->storeUserModel::query()
			->where([['is_forbidden', '=', 1],])
			->where($closure)
			->first($this->storeUserModel->searchFields);

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
		return $this->storeUserModel::query()->where($updateWhere)->update($updateInfo);
	}

	/**
	 * 删除数据.
	 *
	 * @param array $deleteWhere 删除条件
	 * @return int 删除行数
	 */
	public function repositoryDelete(array $deleteWhere): int
	{
		// TODO: Implement repositoryDelete() method.
	}

	/**
	 * 范围删除.
	 *
	 * @param array $deleteWhere 删除条件
	 * @param string $field 删除字段
	 */
	public function repositoryWhereInDelete(array $deleteWhere, string $field): int
	{
		// TODO: Implement repositoryWhereInDelete() method.
	}
}
