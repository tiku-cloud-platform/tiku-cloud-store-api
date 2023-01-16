<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 书籍基础信息
 * @package App\Model\Common
 */
class StoreBook extends BaseModel
{
    protected $table = 'store_book';

    protected $fillable = [
        "uuid",
        "store_uuid",
        "file_uuid",
        "title",
        "author",
        "tags",
        "source",
        "numbers",
        "intro",
        "collection_number",
        "click_number",
        "level",
        "score",
        "is_show",
        "orders",
    ];

    protected $appends = [
        "read_number",
    ];

    public function getReadNumberAttribute(): int
    {
        return (int)(new StoreBookContent())::query()->where([
            ["store_book_uuid", "=", $this->getAttribute("uuid")]
        ])->sum("read_number");
    }

    public function coverFileInfo(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }

    public function getTagsAttribute($key)
    {
        return empty($key) ? [] : explode(",", $key);
    }
}