<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 用户分组
 *
 * Class StoreWeChatUserGroup
 * @package App\Model\Common
 */
class StorePlatformUserGroup extends BaseModel
{
    protected $table = 'store_platform_user_grade';

    protected $fillable = [
        'title',
        'store_uuid',
        'uuid',
        'is_show',
        "is_default",
        "remark",
        "file_uuid",
        "score",
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

    public function getRemarkAttribute($key): string
    {
        return !empty($key) ? $key : "";
    }

    public function icon(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, "file_uuid", "uuid");
    }
}