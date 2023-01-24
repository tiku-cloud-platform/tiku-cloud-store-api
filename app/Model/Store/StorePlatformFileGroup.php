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
 * 平台文件组配置.
 *
 * Class StorePlatformFileGroup
 */
class StorePlatformFileGroup extends \App\Model\Common\StorePlatformFileGroup
{
    public function children()
    {
        return $this->hasMany(StorePlatformFileGroup::class, 'parent_uuid', 'uuid');
    }
}
