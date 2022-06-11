<?php
declare(strict_types=1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 书籍分类
 * @package App\Model\Common
 */
class StoreBookCategory extends BaseModel
{
	protected $table = "store_book_category";

	protected $fillable = [
		"uuid",
		"store_uuid",
		"store_book_uuid",
		"title",
		"parent_uuid",
		"is_show",
		"orders",
	];

	public function book(): BelongsTo
	{
		return $this->belongsTo(StoreBook::class, "store_book_uuid", "uuid");
	}
}