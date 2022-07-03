<?php
declare(strict_types=1);

namespace App\Mapping;

use App\Constants\CacheKey;
use App\Service\Store\Config\PlatformSettingService;

/**
 * 发送微信请求
 *
 * Class WeChatRequest
 * @package App\Mapping
 */
class WeChatRequest
{
	/**
	 * 获取微信小程序端token
	 *
	 * @param string $storeUUID 商户端id
	 * @return string
	 */
	public function getMiNIWeChatToken(string $storeUUID): string
	{
		$accessToken = RedisClient::get(CacheKey::STORE_MINI_WECHAT_TOKEN, $storeUUID);
		if (empty($accessToken)) {
			// 获取微信小程序配置
			$wxSettingInfo = (new PlatformSettingService)->serviceFind((array)['type' => 'wx_setting']);

			if (!empty($wxSettingInfo)) {
				$appId     = $wxSettingInfo['values']['app_key'];
				$appSecret = $wxSettingInfo['values']['app_secret'];

				$url  = ThirdPlatformApi::WX_MINI_ACCESS_TOKEN . "appid={$appId}&secret={$appSecret}";
				$info = (new HttpRequest())->getRequest($url);
				if ($info['code'] == 0 && !isset($info['data']['errcode'])) {
					RedisClient::create(CacheKey::STORE_MINI_WECHAT_TOKEN,
						$storeUUID,
						['access_token' => $info['data']['access_token'],
						 'create_time'  => date('Y-m-d H:i:s'),
						 'expire_time'  => date('Y-m-d H:i:s', time() + $info['data']['expires_in'])],
						(int)$info['data']['expires_in'] - 200,);
					return $info['data']['access_token'];
				} else {
					return '';
				}
			}

			return '';
		}

		return $accessToken['access_token'];
	}

	/**
	 * 提交小程序收录页面
	 *
	 * @param string $accessToken
	 * @param array $pages
	 * @return array
	 */
	public function submitPages(string $accessToken, array $pages): array
	{
		return (new HttpRequest())->postRequest(ThirdPlatformApi::WX_SEARCH_SUBMIT_PAGES . $accessToken,
			['json' => ['pages' => $pages['data']]]);
	}
}