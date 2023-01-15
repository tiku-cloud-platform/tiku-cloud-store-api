<?php
declare(strict_types = 1);

namespace App\Model\Store;

use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 用户端菜单
 *
 * Class StoreMenu
 * @package App\Model\Store
 */
class StoreMenu extends \App\Model\Common\StoreMenu
{
    public $searchFields = [
        'uuid',
        'title',
        'file_uuid',
        'type',
        'url',
        'position_position',
        'orders',
        'is_show',
        "client_position",
    ];

    /**
     * 客户端端口
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(StoreDictionary::class, "client_position", "uuid");
    }

    /**
     * 显示位置
     * @return BelongsTo
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(StoreDictionary::class, "position_position", "uuid");
    }
}