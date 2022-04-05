<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 注册渠道分区
 */
class StoreChannelGroup extends BaseModel
{
    protected $table = "store_channel_group";

    protected $fillable = [
        'uuid',
        'title',
        'is_show',
        'store_uuid',
    ];
}