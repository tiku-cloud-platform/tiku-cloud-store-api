<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 用户端菜单
 * Class StoreMenu
 * @package App\Model\Common
 */
class StoreMenu extends BaseModel
{
    protected $table = 'store_menu';

    protected $fillable = [
        'uuid',
        'title',
        'file_uuid',
        'type',
        'url',
        'position_position',
        'orders',
        'is_show',
        'store_uuid',
        "client_position",
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
    public function coverFileInfo()
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }
}