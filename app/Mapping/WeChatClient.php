<?php
declare(strict_types=1);

namespace App\Mapping;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * 微信小程序端客户信息
 *
 * Class WeChatClient
 * @package App\Mapping
 */
class WeChatClient
{
	/**
	 * @Inject()
	 * @var RequestInterface
	 */
	protected $request;

	/**
	 *  获取商户端的uuid
	 *
	 * @return string
	 */
	public function getUUIDHeader()
	{
		return $this->request->header('Store', '');
	}
}