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
        "id",
        "uuid",
        "title",
        "is_show",
        "store_uuid",
        "channel_group_uuid",
        "created_at",
        "file_uuid",
        "remark",
    ];

    protected $appends = [
        "register"
    ];

    public function getRegisterAttribute(): int
    {
        return (new StorePlatformUser())::query()->where("channel_uuid", "=", $this->attributes["uuid"])->count();
    }
}