<?php
declare(strict_types=1);

namespace App\Controller\Store\Subscribe;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\Subscribe\ConfigValidate;
use App\Service\Store\Subscribe\ConfigService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 微信订阅消息配置
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/subscribe/config")
 * Class ConfigController
 * @package App\Controller\Store\Subscribe
 */
class ConfigController extends StoreBaseController
{
	public function __construct(ConfigService $configService)
	{
		$this->service = $configService;
		parent::__construct($configService);
	}

	/**
	 * @GetMapping(path="list")
	 * @return ResponseInterface
	 */
	public function index(): ResponseInterface
	{
		$items = $this->service->serviceSelect((array)$this->request->all());

		return $this->httpResponse->success((array)$items);
	}

	/**
	 * @GetMapping(path="show")
	 * @param UUIDValidate $validate
	 * @return ResponseInterface
	 */
	public function show(UUIDValidate $validate): ResponseInterface
	{
		$bean = $this->service->serviceFind((array)$this->request->all());

		return $this->httpResponse->success($bean);
	}

	/**
	 * @PostMapping(path="create")
	 * @param ConfigValidate $validate
	 * @return ResponseInterface
	 */
	public function create(ConfigValidate $validate): ResponseInterface
	{
		$createResult = $this->service->serviceCreate((array)$this->request->all());

		return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * @PostMapping(path="update")
	 * @param ConfigValidate $validate
	 * @return ResponseInterface
	 */
	public function update(ConfigValidate $validate): ResponseInterface
	{
		$updateResult = $this->service->serviceUpdate((array)$this->request->all());

		return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * @DeleteMapping(path="delete")
	 * @return ResponseInterface
	 */
	public function destroy(): ResponseInterface
	{
		$deleteResult = $this->service->serviceDelete((array)$this->request->all());

		return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * 发送微信小程序订阅消息
	 * @PostMapping(path="mini_send")
	 * @param UUIDValidate $validate
	 * @return ResponseInterface
	 */
	public function send(UUIDValidate $validate): ResponseInterface
	{
		$sendResult = $this->service->serviceSend($this->request->all());
		return $this->httpResponse->success($sendResult);
		if (!$sendResult["code"]) {
			return $this->httpResponse->success();
		}
		return $this->httpResponse->response((string)$sendResult["msg"]);
	}
}