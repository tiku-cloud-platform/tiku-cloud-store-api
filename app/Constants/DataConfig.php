<?php
declare(strict_types=1);

namespace App\Constants;

/**
 * 功能数据配置
 */
class DataConfig
{
	public static function bannerClientType(): array
	{
		return [
			1 => '微信小程序',
			2 => '抖音小程序',
			3 => '百度小程序',
			4 => '网页端',
			5 => 'H5'
		];
	}
}