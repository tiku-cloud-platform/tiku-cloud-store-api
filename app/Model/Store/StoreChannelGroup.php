<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 渠道分组
 * Class StoreChannelGroup
 * @package App\Model\Store
 */
class StoreChannelGroup extends \App\Model\Common\StoreChannelGroup
{
    public $searchFields = [
        "id",
        "uuid",
        "title",
        "is_show",
        "created_at",
    ];
}