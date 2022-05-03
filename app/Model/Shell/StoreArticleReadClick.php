<?php
declare(strict_types=1);

namespace App\Model\Shell;

use App\Model\Model;

/**
 * 文章阅读、点赞处理
 * @package App\Model\Shell
 */
class StoreArticleReadClick extends Model
{
	protected $table = "store_article_read_click";

	/**
	 * 批量插入记录
	 * @param array $insertInfo
	 * @return bool
	 */
	public function batchInsert(array $insertInfo): bool
	{
		return self::query()->insert($insertInfo);
	}
}