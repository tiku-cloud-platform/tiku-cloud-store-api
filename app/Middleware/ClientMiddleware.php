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

namespace App\Middleware;

use App\Constants\CacheKey;
use App\Mapping\HttpDataResponse;
use App\Mapping\RedisClient;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 验证客户端中间件
 *
 * Class ClientMiddleware
 */
class ClientMiddleware implements MiddlewareInterface
{
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @Inject
	 * @var RequestInterface
	 */
	protected $request;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$header    = $this->request->header('Client-Type', '');
		$storeUUID = $this->request->header('Store', '');
		$wxAppId   = $this->request->header('AppID');
		if (empty($header) || empty($storeUUID)) {
			return (new HttpDataResponse)->response((string)'客户端参数异常');
		}
		// 验证小程序的请求是否属于合法请求
		$wxAppSettingCache = RedisClient::get((string)CacheKey::STORE_MINIPROGRAM_SETTING, (string)$storeUUID);
		if (empty($wxAppSettingCache) && $header == 'wechat') {
			return (new HttpDataResponse())->response((string)'配置信息不存在');
		}
		if ($wxAppId != $wxAppSettingCache['values']['app_key'] && $header == 'wechat') {
			return (new HttpDataResponse())->response((string)'小程序不匹配');
		}

		return $handler->handle($request);
	}
}
