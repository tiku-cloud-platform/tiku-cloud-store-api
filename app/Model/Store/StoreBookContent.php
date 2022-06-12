<?php
declare(strict_types=1);

namespace App\Model\Store;

use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 书籍内容
 * @package App\Model\Store
 */
class StoreBookContent extends \App\Model\Common\StoreBookContent
{
	public function book(): BelongsTo
	{
		return $this->belongsTo(StoreBook::class, "store_book_uuid", "uuid");
	}
}