<?php
declare(strict_types=1);

namespace App\Model\User;

/**
 * 商户平台用户分组
 *
 * Class StorePlatformUserGroup
 * @package App\Model\User
 */
class StorePlatformUserGroup extends \App\Model\Common\StorePlatformUserGroup
{
    public $searchFields = [
        'uuid',
        'title'
    ];
}