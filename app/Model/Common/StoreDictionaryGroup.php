<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 字典分组
 */
class StoreDictionaryGroup extends BaseModel
{
    protected $table = "store_dictionary_group";

    protected $fillable = [
        "uuid",
        "store_uuid",
        "title",
        "code",
        "is_system",
        "is_show",
        "remark",
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