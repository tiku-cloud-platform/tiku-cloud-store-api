<?php
declare(strict_types = 1);

namespace App\Model\User;


use App\Mapping\UserInfo;

/**
 * 平台消息内容
 *
 * Class StorePlatformMessageContent
 * @package App\Model\User
 */
class StorePlatformMessageContent extends \App\Model\Common\StorePlatformMessageContent
{
    public $searchFields = [
        'uuid',
        'platform_message_category_uuid',
        'title',
        'content',
        'created_at'
    ];

    public $listSearchFields = [
        'uuid',
        'platform_message_category_uuid',
        'title',
        'created_at'
    ];

    protected $appends = [
        'is_read'
    ];

    public function getCreatedAtAttribute($key)
    {
        return date('Y-m-d', strtotime($key));
    }

    // 对应消息是否阅读
    public function getIsReadAttribute($key)
    {
        if (StorePlatformMessageHistory::query()
            ->where([
                ['platform_message_content_uuid', '=', $this->attributes['uuid']],
                ['user_uuid', '=', UserInfo::getWeChatUserInfo()['user_uuid']]
            ])
            ->first(['uuid'])) {
            return 1;
        }

        return 0;
    }
}