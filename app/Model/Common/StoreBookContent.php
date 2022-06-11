<?php
declare(strict_types=1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 书籍章节
 * @package App\Model\Common
 */
class StoreBookContent extends BaseModel
{
	protected $table = 'store_book_content';

	protected $fillable = [
		"uuid",
		"store_uuid",
		"store_book_uuid",
		"store_book_category_uuid",
		"title",
		"intro",
		"content",
		"author",
		"publish_time",
		"tags",
		"read_number",
		"click_number",
		"collection_number",
		"source",
		"is_show",
		"orders",
	];

	public function getTagsAttribute($key)
	{
		return empty($key) ? [] : explode(",", $key);
	}
}