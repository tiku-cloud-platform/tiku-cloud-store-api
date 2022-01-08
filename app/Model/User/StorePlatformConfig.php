<?php
declare(strict_types=1);

namespace App\Model\User;

/**
 * 平台参数配置
 *
 * Class StorePlatformConfig
 * @package App\Model\User
 */
class StorePlatformConfig extends \App\Model\Common\StorePlatformConfig
{
	public $searchFields = [
		'title',
		'type',
		'values',
		'store_uuid',
	];
}