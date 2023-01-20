<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 签到配置
 */
class StoreSignConfig extends BaseModel
{
    protected $table = "store_sign_config";

    protected $fillable = [
        'uuid',
        'num',
        'score',
        'is_show',
        'store_uuid',
        'remark',
        "is_continue",
    ];
}