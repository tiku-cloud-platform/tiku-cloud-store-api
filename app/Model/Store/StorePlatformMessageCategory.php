<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 平台消息分类
 *
 * Class StorePlatformMessageCategory
 * @package App\Model\Store
 */
class StorePlatformMessageCategory extends \App\Model\Common\StorePlatformMessageCategory
{
    public $searchFields = [
        'uuid',
        'title',
        'file_uuid',
        'is_show',
        'orders',
    ];
}