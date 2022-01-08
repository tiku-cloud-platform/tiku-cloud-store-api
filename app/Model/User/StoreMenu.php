<?php
declare(strict_types = 1);

namespace App\Model\User;

/**
 * 用户端菜单
 *
 * Class StoreMenu
 * @package App\Model\User
 */
class StoreMenu extends \App\Model\Common\StoreMenu
{
    public $searchFields = [
        'title',
        'file_uuid',
        'url',
        'type',
    ];
}