<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 用户分组
 *
 * Class StoreWeChatUserGroup
 * @package App\Model\Common
 */
class StorePlatformUserGroup extends BaseModel
{
    protected $table = 'store_platform_user_group';

    protected $fillable = [
        'title',
        'store_uuid',
        'uuid',
        'is_show',
    ];
}