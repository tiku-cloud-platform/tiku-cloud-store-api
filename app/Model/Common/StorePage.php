<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 商户页面
 */
class StorePage extends BaseModel
{
    protected $table = "store_page";

    protected $fillable = [
        "uuid",
        "store_uuid",
        "title",
        "path",
        "remark",
        "is_show",
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

    public function getRemarkAttribute($key): string
    {
        return !empty($key) ? $key : "";
    }
}