<?php
declare(strict_types = 1);

namespace App\Model\Store;


use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 平台轮播图
 *
 * Class StoreBanner
 * @package App\Model\Store
 */
class StoreBanner extends \App\Model\Common\StoreBanner
{
    public $searchFields = [
        'uuid',
        'title',
        'file_uuid',
        'orders',
        'url',
        'position',
        'is_show',
        'type',
    ];

    /**
     * 显示位置
     *
     * @return BelongsTo
     */
    public function positionShow()
    {
        return $this->belongsTo(StorePlatformConstConfig::class, 'position', 'value')
            ->where('title', '=', 'wechat_banner');
    }

    /**
     * 跳转类型
     *
     * @return BelongsTo
     */
    public function menuType()
    {
        return $this->belongsTo(StorePlatformConstConfig::class, 'type', 'value')
            ->where('title', '=', 'wechat_banner_navi');
    }
}