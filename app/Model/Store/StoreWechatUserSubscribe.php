<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 微信订阅消息
 *
 * Class StoreWechatUserSubscribe
 * Author 卡二条
 * Email 2665274677@qq.com
 * Date 2021/9/20
 * @package App\Model\Store
 */
class StoreWechatUserSubscribe extends \App\Model\Common\StoreWechatUserSubscribe
{
    public $searchFields = [
        'user_uuid',
        'template_config_uuid',
        'is_used',
        'created_at',
    ];

    public function getIsUsedAttribute($key)
    {
        return -$key;
    }

    public function wechatTemplate()
    {
        return $this->belongsTo(StoreWechatSubscribeConfig::class, 'template_config_uuid', 'uuid');
    }
}