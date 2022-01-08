<?php
declare(strict_types=1);

namespace App\Model\Store;


/**
 * 积分配置
 *
 * Class StorePlatformScore
 * @package App\Model\Store
 */
class StorePlatformScore extends \App\Model\Common\StorePlatformScore
{
	public $searchFields = [
		'uuid',
		'key',
		'title',
		'score',
		'is_show',
	];
}