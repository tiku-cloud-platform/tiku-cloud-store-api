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

use App\Model\Common\StorePlatformUser as StorePlatformUserModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 微信用户
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
        'created_at',
        'updated_at',
        'store_platform_user_group_uuid'
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(StorePlatformUserGroup::class, 'store_platform_user_group_uuid', 'uuid');
    }
}
