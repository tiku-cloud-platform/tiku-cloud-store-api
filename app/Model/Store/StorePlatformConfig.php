<?php

declare(strict_types=1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Model\Store;

/**
 * 平台参数配置.
 *
 * Class StorePlatformConfig
 */
class StorePlatformConfig extends \App\Model\Common\StorePlatformConfig
{
	public $searchFields = [
		'uuid',
		'title',
		'type',
		'values',
		'created_at',
	];
}
