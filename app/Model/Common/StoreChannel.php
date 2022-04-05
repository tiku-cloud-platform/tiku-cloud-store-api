<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 注册渠道
 */
class StoreChannel extends BaseModel
{
    protected $table = "store_channel";

    protected $fillable = [
        'uuid',
        'title',
        'is_show',
        'store_uuid',
        "channel_group_uuid",
        "file_uuid",
        "remark"
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(StoreChannelGroup::class, "channel_group_uuid", "uuid");
    }

    public function fileInfo(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, "file_uuid", "uuid");
    }
}