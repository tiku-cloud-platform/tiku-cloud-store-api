<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 平台内容介绍
 * Class StorePlatformContent
 * @package App\Model\Common
 */
class StorePlatformContent extends BaseModel
{
    protected $table = 'store_platform_content';

    protected $fillable = [
        'uuid',
        'position',
        'content',
        'is_show',
        'store_uuid',
        'title',
        'orders',
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