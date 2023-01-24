<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

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
        "read_score",
        "share_score",
        "click_score",
        "collection_score",
        "read_expend_score",
        "create_id",
    ];

    protected $hidden = ["create_id"];

    /**
     * 创建人信息
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(StoreUser::class, "create_id", "id");
    }

    public function getTagsAttribute($key)
    {
        return empty($key) ? [] : explode(",", $key);
    }
}