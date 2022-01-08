<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 微信订阅消息配置
 *
 * Class StoreWechatSubscribeConfig
 * @package App\Model\Store
 */
class StoreWechatSubscribeConfig extends \App\Model\Common\StoreWechatSubscribeConfig
{
    public $searchFields = [
        'uuid',
        'title',
        'template_id',
        'page',
        'data',
        'miniprogram_state',
        'lang',
        'is_show',
        'orders',
        'file_uuid',
        'description'
    ];
}