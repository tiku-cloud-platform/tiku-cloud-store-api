<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

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
    ];

    public function getRemarkAttribute($key): string
    {
        return !empty($key) ? $key : "";
    }
}