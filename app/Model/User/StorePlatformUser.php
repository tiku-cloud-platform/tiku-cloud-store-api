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

namespace App\Model\User;

use App\Model\Common\StorePlatformUser as StorePlatformUserModel;

/**
 * 微信用户.
 *
 * Class StorePlatformUser
 */
class StorePlatformUser extends StorePlatformUserModel
{
    public $searchFields = [
        'uuid',
        'openid',
        'nickname',
        'avatar_url',
        'gender',
        'country',
        'province',
        'city',
        'is_forbidden',
        'language',
        'real_name',
        'mobile',
        'address',
        'longitude',
        'latitude',
        'district',
        'birthday',
        'login_token',
        'store_uuid',
    ];
}
