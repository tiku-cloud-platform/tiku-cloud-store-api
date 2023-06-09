<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 平台消息内容
 *
 * Class StorePlatformMessageContent
 * @package App\Model\Store
 */
class StorePlatformMessageContent extends \App\Model\Common\StorePlatformMessageContent
{


    public function category()
    {
        return $this->belongsTo(StorePlatformMessageCategory::class, 'platform_message_category_uuid', 'uuid');
    }
}