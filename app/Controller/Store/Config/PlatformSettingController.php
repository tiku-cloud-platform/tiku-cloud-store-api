<?php
declare(strict_types=1);

namespace App\Controller\Store\Config;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\Config\SettingValidate;
use App\Service\Store\Config\PlatformSettingService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 平台参数配置
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/config")
 * Class PlatformSettingController
 */
class PlatformSettingController extends StoreBaseController
{
	public function __construct(PlatformSettingService $settingService)
	{
		$this->service = $settingService;
		parent::__construct($settingService);
	}

	/**
	 * @GetMapping(path="setting/list")
	 * @return ResponseInterface
	 */
	public function index()
	{
		$items = $this->service->serviceSelect($this->request->all());

		return $this->httpResponse->success($items);
	}

	/**
	 * @GetMapping(path="setting/show")
	 * @param UUIDValidate $validate
	 * @return ResponseInterface
	 */
	public function show(UUIDValidate $validate)
	{
		$bean = $this->service->serviceFind($this->request->all());

		return $this->httpResponse->success($bean);
	}

	/**
	 * @PostMapping(path="setting/create")
	 * @param SettingValidate $validate
	 * @return ResponseInterface
	 */
	public function create(SettingValidate $validate)
	{
		$createResult = $this->service->serviceCreate($this->request->all());

		return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * @PutMapping(path="setting/update")
	 * @param SettingValidate $validate
	 * @return ResponseInterface
	 */
	public function update(SettingValidate $validate)
	{
		$updateResult = $this->service->serviceUpdate($this->request->all());

		return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * @DeleteMapping(path="setting/delete")
	 * @return ResponseInterface
	 */
	public function destroy()
	{
		$deleteResult = $this->service->serviceDelete($this->request->all());

		return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}
}
