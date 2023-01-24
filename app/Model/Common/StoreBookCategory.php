<?php
declare(strict_types = 1);

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
        "create_id",
    ];

    protected $appends = [
        "children"
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

    public function book(): BelongsTo
    {
        return $this->belongsTo(StoreBook::class, "store_book_uuid", "uuid");
    }

    public function getChildrenAttribute()
    {
        return (new self())::query()->where([
            ["parent_uuid", "=", $this->getAttribute("uuid")]
        ])->get(["uuid", "title"]);
    }
}