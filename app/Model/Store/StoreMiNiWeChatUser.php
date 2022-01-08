<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 微信小程序用户
 *
 * Class StoreMiNiWeChatUser
 * @package App\Model\Store
 */
class StoreMiNiWeChatUser extends \App\Model\Common\StoreMiNiWeChatUser
{
    public $listSearchFields = [
        'uuid',
        'user_uuid',
        'store_uuid',
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
        'is_show',
        'created_at',
    ];
}