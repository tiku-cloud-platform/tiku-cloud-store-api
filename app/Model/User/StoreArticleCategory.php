<?php
declare(strict_types=1);

namespace App\Model\User;


/**
 * 文章分类
 *
 * Class StoreArticleCategory
 * @package App\Model\User
 */
class StoreArticleCategory extends \App\Model\Common\StoreArticleCategory
{
	public $searchFields = [
		'uuid',
		'parent_uuid',
		'title',
		'file_uuid',
	];
}