<?php
declare(strict_types=1);

namespace App\Model\Store;

/**
 * 活动奖品关联
 * Class StoreActivityPrizeRelation
 * @package App\Model\Store
 */
class StoreActivityPrizeRelation extends \App\Model\Common\StoreActivityPrizeRelation
{
    public $listSearchFields = [
        'uuid',
        'activity_uuid',
        'prize_uuid',
        'stock',
        'orders',
        'is_show',
        'created_at',
        'updated_at',
    ];
}