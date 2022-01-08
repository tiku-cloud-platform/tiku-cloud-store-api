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
 * 商户信息.
 *
 * Class StoreUser
 */
class StoreUser extends BaseModel
{
    protected $table = 'store_user';

    public function getCompanyNameAttribute($key): string
    {
        return !empty($key) ? $key : '暂未设置';
    }

    public function getCompanyTelAttribute($key): string
    {
        return !empty($key) ? $key : '暂未设置';
    }
}
