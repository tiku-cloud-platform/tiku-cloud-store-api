<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 用户分组
 *
 * Class StoreWeChatUserGroup
 * @package App\Model\Store
 */
class StorePlatformUserGroup extends \App\Model\Common\StorePlatformUserGroup
{
    public $searchFields = [
        'title',
        'uuid',
        'created_at',
        'is_show',
        "is_default",
        "remark",
        "file_uuid",
        "score",
    ];
}