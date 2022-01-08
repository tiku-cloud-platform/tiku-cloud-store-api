<?php
declare(strict_types=1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 文章管理
 *
 * Class StoreArticle
 * @package App\Model\Common
 */
class StoreArticle extends BaseModel
{
	protected $table = 'store_article';

	protected $fillable = [
		'uuid',
		'article_category_uuid',
		'store_uuid',
		'title',
		'file_uuid',
		'content',
		'publish_date',
		'author',
		'source',
		'read_number',
		'orders',
		'is_show',
		'is_top',
	];

	/**
	 * 文章封面
	 *
	 * @return BelongsTo
	 * @author kert
	 */
	public function coverFileInfo()
	{
		return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
	}

	/**
	 * 文章分类
	 *
	 * @return BelongsTo
	 */
	public function categoryInfo()
	{
		return $this->belongsTo(StoreArticleCategory::class, 'article_category_uuid', 'uuid');
	}
}