<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 文章分类管理
 *
 * Class StoreArticleCategory
 * @package App\Model\Store
 */
class StoreArticleCategory extends \App\Model\Common\StoreArticleCategory
{
    public $searchFields = [
        'uuid',
        'parent_uuid',
        'title',
        'file_uuid',
        'orders',
        'is_show',
    ];
}