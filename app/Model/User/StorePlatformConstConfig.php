<?php
declare(strict_types = 1);

namespace App\Model\User;

/**
 * 系统常量配置
 * Class StorePlatformConstConfig
 * @package App\Model\User
 */
class StorePlatformConstConfig extends \App\Model\Common\StorePlatformConstConfig
{
    public $searchFields = [
        'title',
        'describe',
        'value',
    ];
}