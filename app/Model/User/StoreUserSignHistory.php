<?php
declare(strict_types = 1);

namespace App\Model\User;

/**
 * 用户签到历史记录
 *
 * Class StoreUserSignHistory
 * @package App\Model\User
 */
class StoreUserSignHistory extends \App\Model\Common\StoreUserSignHistory
{
    public $searchFields = [
        'uuid',
        'user_uuid',
        'sign_date',
    ];
}