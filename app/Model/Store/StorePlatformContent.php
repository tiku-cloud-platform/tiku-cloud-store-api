<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 平台内容介绍
 *
 * Class StorePlatformContent
 * @package App\Model\Store
 */
class StorePlatformContent extends \App\Model\Common\StorePlatformContent
{
    public $searchFields = [
        'uuid',
        'position',
        'content',
        'is_show',
        'content',
        'title',
        'orders',
    ];
}