<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 平台消息分类
 *
 * Class StorePlatformMessageCategory
 * @package App\Model\Common
 */
class StorePlatformMessageCategory extends BaseModel
{
    protected $table = 'store_platform_message_category';

    protected $fillable = [
        'uuid',
        'title',
        'file_uuid',
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

    /**
     * 封面地址
     * @return BelongsTo
     * @author kert
     */
    public function coverFileInfo(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }
}