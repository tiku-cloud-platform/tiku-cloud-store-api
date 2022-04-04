<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 统计渠道
 * Class StoreChannel
 * @package App\Model\Store
 */
class StoreChannel extends \App\Model\Common\StoreChannel
{
    public $searchFields = [
        "uuid",
        "title",
        "is_show",
        "store_uuid",
        "channel_group_uuid",
        "created_at"
    ];
}