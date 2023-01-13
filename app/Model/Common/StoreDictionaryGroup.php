<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

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
    ];

    public function getRemarkAttribute($key): string
    {
        return !empty($key) ? $key : "";
    }
}