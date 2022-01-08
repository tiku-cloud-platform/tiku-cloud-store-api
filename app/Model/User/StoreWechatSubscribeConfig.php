<?php
declare(strict_types = 1);

namespace App\Model\User;

use App\Mapping\UserInfo;

/**
 * 微信订阅消息
 *
 * Class StoreWechatSubscribeConfig
 * @package App\Model\User
 */
class StoreWechatSubscribeConfig extends \App\Model\Common\StoreWechatSubscribeConfig
{
    public $searchFields = [
        'uuid',
        'title',
        'template_id',
        'file_uuid',
    ];

    protected $appends = [
        'config_number'// 剩余提醒次数
    ];

    public function getConfigNumberAttribute($key)
    {
        $userInfo = UserInfo::getWeChatUserInfo();
        if (!empty($userInfo)) {
            return StoreWechatUserSubscribe::query()
                ->where('user_uuid', '=', $userInfo['user_uuid'])
                ->where('template_config_uuid', '=', $this->attributes['uuid'])
                ->count();
        }

        return 0;
    }
}