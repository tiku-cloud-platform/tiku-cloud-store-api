<?php
declare(strict_types=1);

namespace App\Controller\Store\Message;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\Message\CategoryValidate;
use App\Service\Store\Message\CategoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 平台消息分类
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/message/category")
 * Class CategoryController
 * @package App\Controller\Store\Message
 */
class CategoryController extends StoreBaseController
{
	public function __construct(CategoryService $categoryService)
	{
		$this->service = $categoryService;
		parent::__construct($categoryService);
	}

	/**
	 * @GetMapping(path="list")
	 * @return ResponseInterface
	 */
	public function index()
	{
		$items = $this->service->serviceSelect((array)$this->request->all());

		return $this->httpResponse->success((array)$items);
	}

	/**
	 * @GetMapping(path="show")
	 * @param UUIDValidate $validate
	 * @return ResponseInterface
	 */
	public function show(UUIDValidate $validate)
	{
		$bean = $this->service->serviceFind((array)$this->request->all());

		return $this->httpResponse->success($bean);
	}

	/**
	 * @PostMapping(path="create")
	 * @param CategoryValidate $validate
	 * @return ResponseInterface
	 */
	public function create(CategoryValidate $validate)
	{
		$createResult = $this->service->serviceCreate((array)$this->request->all());

		return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * @PutMapping(path="update")
	 * @param CategoryValidate $validate
	 * @return ResponseInterface
	 */
	public function update(CategoryValidate $validate)
	{
		$updateResult = $this->service->serviceUpdate((array)$this->request->all());

		return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * @DeleteMapping(path="delete")
	 * @return ResponseInterface
	 */
	public function destroy()
	{
		$deleteResult = $this->service->serviceDelete((array)$this->request->all());

		return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}
}