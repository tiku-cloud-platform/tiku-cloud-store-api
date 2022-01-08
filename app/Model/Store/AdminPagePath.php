<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 用户页面配置
 * Class AdminPagePath
 * @package App\Model\Store
 */
class AdminPagePath extends \App\Model\Common\AdminPagePath
{
    public $searchFields = [
        'type',
        'path',
        'title'
    ];
}