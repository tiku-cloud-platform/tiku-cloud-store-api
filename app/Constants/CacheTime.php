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

namespace App\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 *  缓存时长配置.
 *
 * @Constants
 * Class CacheTime
 */
class CacheTime extends Constants
{
	/**
	 * @Message("商户端登录token前缀")
	 */
	const STORE_LOGIN_EXPIRE_TIME = 864000;

	/**
	 * @Message("用户端登录token前缀")
	 */
	const USER_LOGIN_EXPIRE_TIME = 864000;


	/**
	 * @Message("商户端系统配置")
	 */
	const STORE_PLATFORM_SETTING_EXPIRE_TIME = 864000;
}
