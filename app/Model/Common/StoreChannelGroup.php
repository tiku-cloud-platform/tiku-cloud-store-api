<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 注册渠道分区
 */
class StoreChannelGroup extends BaseModel
{
    protected $table = "store_channel_group";

    protected $fillable = [
        'uuid',
        'title',
        'is_show',
        'store_uuid',
        "create_id",
    ];

    protected $hidden = ["create_id"];

    /**
     * 创建人信息
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(StoreUser::class, "create_id", "id");
    }
}