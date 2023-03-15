<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/***
 * 教程点评
 */
class StoreBookEvaluateHistory extends BaseModel
{
    protected $table = "store_book_evaluate_history";

    protected $casts = [
        "is_show" => "string"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(StorePlatformUser::class, "user_uuid", "uuid");
    }

    public function mini(): BelongsTo
    {
        return $this->belongsTo(StoreMiNiWeChatUser::class, "user_uuid", "user_uuid");
    }

    public function audit(): BelongsTo
    {
        return $this->belongsTo(StoreUser::class, "audit_user_uuid", "uuid");
    }

    public function getAuditAtAttribute($key): string
    {
        return !empty($key) ? $key : "";
    }
}