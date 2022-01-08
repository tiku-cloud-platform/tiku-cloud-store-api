<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;

/**
 * 平台消息阅读记录
 *
 * Class StorePlatformMessageHistory
 * @package App\Model\Common
 */
class StorePlatformMessageHistory extends BaseModel
{
    protected $table = 'store_platform_message_history';

    protected $fillable = [
        'uuid',
        'platform_message_content_uuid',
        'user_uuid',
        'is_show',
        'store_uuid',
    ];
}