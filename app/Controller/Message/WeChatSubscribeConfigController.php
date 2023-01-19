<?php
declare(strict_types=1);

namespace App\Controller\Message;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\Message\WeChatSubscribeConfigService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 微信订阅消息
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/message/subscribe")
 * Class WeChatSubscribeConfigController
 * @package App\Controller\Store\Message
 */
class WeChatSubscribeConfigController extends StoreBaseController
{
	public function __construct(WeChatSubscribeConfigService $configService)
	{
		$this->service = $configService;
		parent::__construct($configService);
	}

	/**
	 * @GetMapping(path="list")
	 * @return ResponseInterface
	 */
	public function index()
	{
		$items = [
			'items' => [
				['uuid' => time(), 'title' => '模板配置一', 'template_id' => 'adsfasdfasdf', 'is_show' => 1, 'created_at' => time()],
				['uuid' => time(), 'title' => '模板配置一', 'template_id' => 'adsfasdfasdf', 'is_show' => 1, 'created_at' => time()],
				['uuid' => time(), 'title' => '模板配置一', 'template_id' => 'adsfasdfasdf', 'is_show' => 1, 'created_at' => time()],
				['uuid' => time(), 'title' => '模板配置一', 'template_id' => 'adsfasdfasdf', 'is_show' => 1, 'created_at' => time()],
				['uuid' => time(), 'title' => '模板配置一', 'template_id' => 'adsfasdfasdf', 'is_show' => 1, 'created_at' => time()],
				['uuid' => time(), 'title' => '模板配置一', 'template_id' => 'adsfasdfasdf', 'is_show' => 1, 'created_at' => time()],
				['uuid' => time(), 'title' => '模板配置一', 'template_id' => 'adsfasdfasdf', 'is_show' => 1, 'created_at' => time()],
			],
			'page'  => 1,
			'size'  => 20,
			'total' => 100,
		];

		return $this->httpResponse->success((array)$items);
	}
}