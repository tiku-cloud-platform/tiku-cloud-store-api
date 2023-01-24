<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 平台轮播图
 *
 * Class StoreBanner
 * @package App\Model\Common
 */
class StoreBanner extends BaseModel
{
    protected $table = 'store_banner';

    protected $fillable = [
        'uuid',
        'title',
        'file_uuid',
        'orders',
        'url',
        'position_position',
        'is_show',
        'store_uuid',
        'type',
        'client_position',
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
     * 菜单图标地址
     * @return BelongsTo
     * @author kert
     */
    public function coverFileInfo(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }

    public function getTitleAttribute($key): string
    {
        return empty($key) ? '' : $key;
    }
}