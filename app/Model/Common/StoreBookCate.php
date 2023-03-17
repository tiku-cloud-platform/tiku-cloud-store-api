<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\Relations\HasMany;

/**
 * 教程类目
 */
class StoreBookCate extends BaseModel
{
    protected $table = "store_book_cate";

    protected $fillable = [
        "uuid",
        "store_uuid",
        "title",
        "parent_uuid",
        "is_show",
        "orders",
        "create_id",
        "is_home"
    ];

    protected $hidden = ["create_id"];

    public function children(): HasMany
    {
        return $this->hasMany(StoreBookCate::class, "parent_uuid", "uuid")
            ->with(["creator:id,name"]);
    }

    /**
     * 创建人信息
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(StoreUser::class, "create_id", "id");
    }
}