<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 注册渠道
 */
class StoreChannelGroup extends BaseModel
{
    protected  $table = "store_channel";

    protected $fillable = [
        'uuid',
        'title',
        'is_show',
        'store_uuid',
    ];
}