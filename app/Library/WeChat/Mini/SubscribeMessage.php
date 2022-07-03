<?php
declare(strict_types=1);

namespace App\Library\WeChat\Mini;

use App\Mapping\HttpRequest;
use App\Mapping\ThirdPlatformApi;
use App\Mapping\WeChatRequest;

/**
 * 微信订阅消息
 * @package App\Library\WeChat
 */
class SubscribeMessage
{
	/**
	 * 发送微信小程序订阅消息
	 * @param array $sendMessage 发送消息体
	 * @param string $storeUuid  商户编号
	 * @return array
	 */
	public function send(array $sendMessage, string $storeUuid): array
	{
		$accessToken = (new WeChatRequest())->getMiNIWeChatToken($storeUuid);
		return (new HttpRequest())->postRequest(sprintf("%s%s", ThirdPlatformApi::WX_SUBSCRIBEMESSAGE, $accessToken),
			$sendMessage, [
				"header" => [
					"Accept" => "application/json",
				]
			]);
	}
}