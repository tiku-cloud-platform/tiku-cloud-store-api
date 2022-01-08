<?php
declare(strict_types=1);

namespace App\Model\Common;


use App\Model\BaseModel;

/**
 * 文章阅读点赞记录
 *
 * Class StoreArticleReadClick
 * @package App\Model\Common
 */
class StoreArticleReadClick extends BaseModel
{
	protected $table = 'store_article_read_click';

	protected $fillable = [
		'uuid',
		'store_uuid',
		'user_uuid',
		'article_uuid',
		'type',
	];
}