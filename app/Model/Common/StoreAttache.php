<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 附件管理
 */
class StoreAttache extends BaseModel
{
    protected $table = "store_attache";

    protected $fillable = [
        "uuid",
        "title",
        "store_uuid",
        "cate_uuid",
        "download_number",
        "content",
        "type",
        "is_show",
        "orders",
        "create_id",
        "file_uuid"
    ];

    protected $hidden = ["create_id"];

    public function cate(): BelongsTo
    {
        return $this->belongsTo(StoreAttacheCate::class, "cate_uuid", "uuid");
    }

    public function cover(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(StoreUser::class, "create_id", "id");
    }
}