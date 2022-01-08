<?php

declare(strict_types=1);
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
 * 商户平台常量配置.
 *
 * Class StorePlatformConstConfig
 */
class StorePlatformConstConfig extends BaseModel
{
    protected $table = 'store_platform_const_config';

    protected $fillable = [
        'title',
        'describe',
        'value',
        'uuid',
        'store_uuid',
    ];
}
