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

    protected $appends = [
        "register"
    ];

    public function getRegisterAttribute(): int
    {
        $uuid        = $this->attributes["uuid"];
        $items       = (new StoreChannel())::query()->where("channel_group_uuid", "=", $uuid)->get(["uuid"])->toArray();
        $channelUuid = [];
        foreach ($items as $value) {
            $channelUuid[] = $value["uuid"];
        }
        return (new StorePlatformUser())::query()->whereIn("channel_uuid", $channelUuid)->count();
    }
}