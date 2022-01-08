<?php
declare(strict_types = 1);

namespace App\Model\User;

use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 微信小程序用户
 *
 * Class StoreMiNiWeChatUser
 * @package App\Model\User
 */
class StoreMiNiWeChatUser extends \App\Model\Common\StoreMiNiWeChatUser
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
        'store_uuid',
        'user_uuid',
        'created_at',
    ];

    /**
     * 主账号
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(StorePlatformUser::class, 'user_uuid', 'uuid');
    }
}