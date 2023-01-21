<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

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
    ];

    public function getRemarkAttribute($key): string
    {
        return !empty($key) ? $key : "";
    }
}