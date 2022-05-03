<?php
declare(strict_types=1);

namespace App\Model\Shell;

use App\Model\Model;

/**
 * 文章管理
 * @package App\Model\Shell
 */
class StoreArticle extends Model
{
	protected $table = "store_article";

	/**
	 * 批量更新摸个字段值
	 * @param array $uuidArray
	 * @param string $column
	 * @param int $incrVale
	 * @return int
	 */
	public function batchUpdateColumn(array $uuidArray, string $column, int $incrVale = 1): int
	{
		return self::query()->whereIn("uuid", $uuidArray)->increment($column, $incrVale);
	}
}