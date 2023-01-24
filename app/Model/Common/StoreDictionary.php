<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 字典配置
 */
class StoreDictionary extends BaseModel
{
    protected $table = "store_dictionary";

    protected $fillable = [
        "uuid",
        "store_uuid",
        "title",
        "group_uuid",
        "is_system",
        "is_show",
        "remark",
        "value",
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

    public function group(): BelongsTo
    {
        return $this->belongsTo(StoreDictionaryGroup::class, "group_uuid", "uuid");
    }
}