<?php

declare(strict_types = 1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Model\Store;

/**
 * 商户信息.
 *
 * Class StoreUser
 */
class StoreUser extends \App\Model\Common\StoreUser
{
    public $searchFields = [
        'uuid',
        'name',
        'email',
        'password',
        'login_number',
        'mobile',
        'expire_time',
        'avatar',
        'store_uuid',
        'remember_token',
        'company_name',
        'company_tel',
    ];
}
