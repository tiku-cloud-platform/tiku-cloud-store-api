<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 文章管理
 *
 * Class StoreArticle
 * @package App\Model\Store
 */
class StoreArticle extends \App\Model\Common\StoreArticle
{
    public $searchFields = [
        'uuid',
        'article_category_uuid',
        'title',
        'file_uuid',
        'content',
        'publish_date',
        'author',
        'source',
        'read_number',
        'orders',
        'is_show',
        'is_top',
        'is_publish',
    ];
}