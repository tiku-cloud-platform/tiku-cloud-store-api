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
        'login_token',
        'is_show',
        'store_platform_user_group_uuid',
    ];

    // 用户语言
    public function getLanguageAttribute($key)
    {
        return !empty($key) ? $key : '';
    }

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

    // 精度
    public function getLongitudeAttribute($key)
    {
        return !empty($key) ? $key : '';
    }

    // 维度
    public function getLatitudeAttribute($key)
    {
        return !empty($key) ? $key : '';
    }

    // 国家
    public function getCountryAttribute($key)
    {
        return !empty($key) ? $key : '';
    }

    // 省份
    public function getProvinceAttribute($key)
    {
        return !empty($key) ? $key : '';
    }

    // 城市
    public function getCityAttribute($key)
    {
        return !empty($key) ? $key : '';
    }

    // 地区
    public function getDistrictAttribute($key)
    {
        return !empty($key) ? $key : '';
    }

    // 真实地址
    public function getAddressAttribute($key)
    {
        return !empty($key) ? $key : '';
    }

    // 出生日期
    public function getBirthdayAttribute($key)
    {
        return !empty($key) ? $key : '';
    }
}
