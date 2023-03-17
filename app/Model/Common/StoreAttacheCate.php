<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\Relations\HasMany;

/**
 * 附件类目
 */
class StoreAttacheCate extends BaseModel
{
    protected $table = "store_attache_cate";

    protected $fillable = [
        "uuid",
        "store_uuid",
        "title",
        "parent_uuid",
        "is_show",
        "orders",
        "create_id",
        "file_uuid",
    ];

    protected $hidden = ["create_id"];

    public function children(): HasMany
    {
        return $this->hasMany(StoreAttacheCate::class, "parent_uuid", "uuid")
            ->with(["creator:id,name"]);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(StoreUser::class, "create_id", "id");
    }
}