<?php
declare(strict_types=1);

namespace App\Model\Store;

/**
 * 活动奖品
 * Class StoreActivityPrize
 * @package App\Model\Store
 */
class StoreActivityPrize extends \App\Model\Common\StoreActivityPrize
{
    public $listSearchFields = [
        'uuid',
        'store_uuid',
        'file_uuid',
        'title',
        'title',
        'description',
        'introduction',
        'content',
        'worth',
        'type',
        'is_show',
        'created_at',
        'updated_at',
    ];
}