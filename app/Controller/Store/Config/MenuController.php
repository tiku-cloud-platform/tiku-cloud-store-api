<?php
declare(strict_types=1);

namespace App\Controller\Store\Config;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\Config\MenuValidate;
use App\Service\Store\Config\MenuService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户端菜单配置
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/config")
 * Class MenuController
 * @package App\Controller\Store\Config
 */
class MenuController extends StoreBaseController
{
	public function __construct(MenuService $menuService)
	{
		$this->service = $menuService;
		parent::__construct($menuService);
	}

	/**
	 * @GetMapping(path="menu/list")
	 * @return ResponseInterface
	 */
	public function index()
	{
		$items = $this->service->serviceSelect((array)$this->request->all());

		return $this->httpResponse->success((array)$items);
	}

	/**
	 * @GetMapping(path="menu/show")
	 * @param UUIDValidate $validate
	 * @return ResponseInterface
	 */
	public function show(UUIDValidate $validate)
	{
		$bean = $this->service->serviceFind((array)$this->request->all());

		return $this->httpResponse->success($bean);
	}

	/**
	 * @PostMapping(path="menu/create")
	 * @param MenuValidate $validate
	 * @return ResponseInterface
	 */
	public function create(MenuValidate $validate)
	{
		$createResult = $this->service->serviceCreate((array)$this->request->all());

		return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * @PutMapping(path="menu/update")
	 * @param MenuValidate $validate
	 * @return ResponseInterface
	 */
	public function update(MenuValidate $validate)
	{
		$updateResult = $this->service->serviceUpdate((array)$this->request->all());

		return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * @DeleteMapping(path="menu/delete")
	 * @return ResponseInterface
	 */
	public function destroy()
	{
		$deleteResult = $this->service->serviceDelete((array)$this->request->all());

		return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}
}