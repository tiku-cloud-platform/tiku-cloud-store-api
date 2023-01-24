<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 平台消息内容
 *
 * Class StorePlatformMessageContent
 * @package App\Model\Common
 */
class StorePlatformMessageContent extends BaseModel
{
    protected $table = 'store_platform_message_content';

    protected $fillable = [
        'uuid',
        'platform_message_category_uuid',
        'title',
        'content',
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

    public function category()
    {
        return $this->belongsTo(StorePlatformMessageCategory::class,
            'platform_message_category_uuid', 'uuid');
    }
}