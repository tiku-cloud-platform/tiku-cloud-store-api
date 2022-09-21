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

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * 缓存key配置.
 *
 * @Constants
 * Class LoginToken
 */
class CacheKey extends AbstractConstants
{
	/**
	 * @Message("商户端登录token前缀")
	 */
	const STORE_LOGIN_PREFIX = 'store_login:';

	/**
	 * @Message("用户端登录token前缀")
	 */
	const USER_LOGIN_PREFIX = 'user_login:';

	/**
	 * @Message(微信用户每日签到")
	 */
	const USER_SING_DAY = 'wechat:user:sign:';

	/**
	 * @Message("微信小程序配置")
	 */
	const STORE_MINIPROGRAM_SETTING = "store:miniprogram:";

	/**
	 * @Message("公众号配置")
	 */
	const STORE_PUBLICPROGRAM_SETTING = "store:publicprogram:";

	/**
	 * @Message("商户微信小程序token")
	 */
	const STORE_MINI_WECHAT_TOKEN = 'wechat_token:';

	/**
	 * @Message("微信小程序用户积分排行")
	 */
	const WECHAT_RANK_SCORE = 'wechat_rank_score:';

	/**
	 * @Message("云文件存储token前缀")
	 */
	const  CLOUD_PLATFORM_FILE_TOKEN = "cloud_platform_file_token:";

	/**
	 * @Message("试卷基础数据统计")
	 */
	const EXAM_COLLECTION_TOTAL = "exam_collection_total:";
}
