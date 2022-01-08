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
        'position',
        'orders',
        'is_show',
    ];

    /**
     * 显示位置
     *
     * @return BelongsTo
     */
    public function positionShow()
    {
        return $this->belongsTo(StorePlatformConstConfig::class, 'position', 'value')
            ->where('title', '=', 'wechat_menu');
    }

    /**
     * 跳转类型
     *
     * @return BelongsTo
     */
    public function menuType()
    {
        return $this->belongsTo(StorePlatformConstConfig::class, 'type', 'value')
            ->where('title', '=', 'wechat_mini_navi');
    }
}