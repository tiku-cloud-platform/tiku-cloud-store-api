<?php

declare(strict_types = 1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 平台参数配置.
 *
 * Class StorePlatformConfig
 */
class StorePlatformConfig extends BaseModel
{
    protected $table = 'store_platform_setting';

    protected $fillable = [
        'uuid',
        'title',
        'type',
        'values',
        'is_show',
        'store_uuid',
        'file_group_uuid',
        "create_id",
    ];

    protected $casts = [
        'values' => 'array',
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
