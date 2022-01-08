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

namespace App\Repository;

/**
 * Interface StoreRepositoryInterface.
 */
interface StoreRepositoryInterface
{
    /**
     * 查询数据
     *
     * @param \Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
	public function repositorySelect(\Closure $closure, int $perSize): array;

	/**
	 * 创建数据.
	 *
	 * @param array $insertInfo 创建信息
	 * @return bool true|false
	 */
	public function repositoryCreate(array $insertInfo): bool;

	/**
	 * 添加数据
	 *
	 * @param array $addInfo 添加信息
	 * @return int 添加之后的ID或者行数
	 */
	public function repositoryAdd(array $addInfo): int;

	/**
	 * 查询数据
	 *
	 * @param \Closure $closure
	 * @return array
	 * @author kert
	 */
	public function repositoryFind(\Closure $closure): array;

	/**
	 * 更新数据
	 *
	 * @param array $updateWhere 修改条件
	 * @param array $updateInfo 修改信息
	 * @return int 更新行数
	 */
	public function repositoryUpdate(array $updateWhere, array $updateInfo): int;

	/**
	 * 删除数据
	 *
	 * @param array $deleteWhere 删除条件
	 * @return int 删除行数
	 */
	public function repositoryDelete(array $deleteWhere): int;

	/**
	 * 范围删除
	 *
	 * @param array $deleteWhere 删除条件
	 * @param string $field 删除字段
	 * @return int
	 */
	public function repositoryWhereInDelete(array $deleteWhere, string $field): int;
}
