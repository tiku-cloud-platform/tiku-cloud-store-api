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

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 微信用户
 *
 * Class StoreWeChatUser
 */
class StorePlatformUser extends BaseModel
{
    protected $table = 'store_platform_user';

    protected $fillable = [
        'uuid',
        'real_name',
        'mobile',
        'store_uuid',
        'user_uuid',
        'is_show',
        'store_platform_user_group_uuid',
    ];

    // 真实姓名
    public function getRealNameAttribute($key)
    {
        return !empty($key) ? $key : '';
    }

    // 手机号
    public function getMobileAttribute($key)
    {
        return !empty($key) ? $key : '';
    }
}
