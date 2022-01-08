<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;

/**
 * 用户签到历史记录
 *
 * Class StoreUserSignHistory
 * @package App\Model\Common
 */
class StoreUserSignHistory extends BaseModel
{
    protected $table = 'store_user_sign_history';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'sign_date',
        'is_show',
        'store_uuid',
    ];
}