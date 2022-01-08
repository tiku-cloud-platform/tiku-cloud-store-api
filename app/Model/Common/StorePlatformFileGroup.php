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
 * 平台文件组配置.
 *
 * Class StorePlatformFileGroup
 */
class StorePlatformFileGroup extends BaseModel
{
    protected $table = 'store_platform_file_group';

    protected $fillable = [
        'title',
        'store_uuid',
        'uuid',
        'is_show',
        'parent_uuid',
    ];
}
