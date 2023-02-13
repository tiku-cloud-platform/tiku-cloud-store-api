<?php
declare(strict_types = 1);

namespace App\Model\Store;

use App\Model\Common\StorePlatformUser as StorePlatformUserModel;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\Relations\HasOne;

/**
 * 平台用户
 */
class StorePlatformUser extends StorePlatformUserModel
{
    public function group(): BelongsTo
    {
        return $this->belongsTo(StorePlatformUserGroup::class, 'store_platform_user_group_uuid', 'uuid');
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(StoreChannel::class, "channel_uuid", "uuid");
    }

    public function score(): HasOne
    {
        return $this->hasOne(StoreUserScoreCollection::class, "user_uuid", "uuid");
    }

    public function getRemarkAttribute($key): string
    {
        return !empty($key) ? $key : "";
    }

    public function getBirthdayAttribute($key): string
    {
        return !empty($key) ? $key : "";
    }
}
