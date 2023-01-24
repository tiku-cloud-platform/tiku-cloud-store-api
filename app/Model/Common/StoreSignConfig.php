<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 签到配置
 */
class StoreSignConfig extends BaseModel
{
    protected $table = "store_sign_config";

    protected $fillable = [
        'uuid',
        'num',
        'score',
        'is_show',
        'store_uuid',
        'remark',
        "is_continue",
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