<?php
declare(strict_types = 1);

namespace App\Model\User;


/**
 * 平台积分配置
 *
 * Class StorePlatformScore
 * @package App\Model\User
 */
class StorePlatformScore extends \App\Model\Common\StorePlatformScore
{
    public $searchFields = [
        'score',
        'title',
        'uuid',
        'key',
    ];
}