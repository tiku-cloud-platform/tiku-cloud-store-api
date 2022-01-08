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
 * 商户平台常量配置.
 *
 * Class StorePlatformConstConfig
 */
class StorePlatformConstConfig extends \App\Model\Common\StorePlatformConstConfig
{
    public $searchFields = [
        'title',
        'describe',
        'value',
        'created_at',
    ];
}
