<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 平台积分配置
 *
 * Class StorePlatformScore
 * @package App\Model\Common
 */
class StorePlatformScore extends BaseModel
{
    protected $table = 'store_platform_score';

    protected $fillable = [
        'uuid',
        'key',
        'title',
        'score',
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