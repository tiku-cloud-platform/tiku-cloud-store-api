<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;

/**
 * 用户签到汇总
 *
 * Class StoreUserSignCollection
 * @package App\Model\Common
 */
class StoreUserSignCollection extends BaseModel
{
    protected $table = 'store_user_sign_collection';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'sign_number',
        'store_uuid',
        'is_show',
    ];
}