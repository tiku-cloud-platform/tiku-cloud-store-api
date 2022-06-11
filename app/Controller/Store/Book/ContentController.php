<?php
declare(strict_types=1);

namespace App\Controller\Store\Book;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Book\ContentSearchValidate;
use App\Request\Store\Book\ContentValidate;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Store\Book\ContentService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 书籍目录
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/book_content")
 * Class ContentController
 * @package App\Controller\Store\Book
 */
class ContentController extends StoreBaseController
{
	public function __construct(ContentService $articleService)
	{
		$this->service = $articleService;
		parent::__construct($articleService);
	}

	/**
	 * @GetMapping(path="list")
	 * @param ContentSearchValidate $validate
	 * @return ResponseInterface
	 */
	public function index(ContentSearchValidate $validate): ResponseInterface
	{
		$items = $this->service->serviceSelect($this->request->all());

		return $this->httpResponse->success($items);
	}

	/**
	 * @GetMapping(path="show")
	 * @param UUIDValidate $validate
	 * @return ResponseInterface
	 */
	public function show(UUIDValidate $validate): ResponseInterface
	{
		$bean = $this->service->serviceFind($this->request->all());

		return $this->httpResponse->success($bean);
	}

	/**
	 * @PostMapping(path="create")
	 * @param ContentValidate $validate
	 * @return ResponseInterface
	 */
	public function create(ContentValidate $validate): ResponseInterface
	{
		$createResult = $this->service->serviceCreate($this->request->all());

		return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * @PostMapping(path="update")
	 * @param ContentValidate $validate
	 * @return ResponseInterface
	 */
	public function update(ContentValidate $validate): ResponseInterface
	{
		$updateResult = $this->service->serviceUpdate($this->request->all());

		return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * @DeleteMapping(path="delete")
	 * @return ResponseInterface
	 */
	public function destroy(): ResponseInterface
	{
		$deleteResult = $this->service->serviceDelete($this->request->all());

		return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}
}