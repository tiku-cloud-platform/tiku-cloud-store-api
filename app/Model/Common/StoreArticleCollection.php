<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 文章收藏记录
 * Class StoreArticleCollection
 * @package App\Model\Common
 */
class StoreArticleCollection extends BaseModel
{
    protected $table = 'store_article_collection_history';
}