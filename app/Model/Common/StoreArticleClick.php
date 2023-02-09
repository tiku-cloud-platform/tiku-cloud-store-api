<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;

/**
 * 文章点赞记录
 * Class StoreArticleReadClick
 * @package App\Model\Common
 */
class StoreArticleClick extends BaseModel
{
    protected $table = 'store_article_click_history';
}