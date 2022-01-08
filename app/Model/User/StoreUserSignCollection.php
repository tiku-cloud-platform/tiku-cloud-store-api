<?php
declare(strict_types = 1);

namespace App\Model\User;


/**
 * 用户积分汇总
 *
 * Class StoreUserSignCollection
 * @package App\Model\User
 */
class StoreUserSignCollection extends \App\Model\Common\StoreUserSignCollection
{
    public $searchFields = [
        'uuid',
        'user_uuid',
        'sign_number',
    ];
}