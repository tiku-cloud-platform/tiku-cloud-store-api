<?php
declare(strict_types=1);

namespace App\Controller\Store\Book;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Article\ArticleValidate;
use App\Request\Store\Book\BookValidate;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Store\Book\BookService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 书籍管理
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/book_basic")
 * Class BookController
 * @package App\Controller\Store\Book
 */
class BookController extends StoreBaseController
{
	public function __construct(BookService $articleService)
	{
		$this->service = $articleService;
		parent::__construct($articleService);
	}

	/**
	 * @GetMapping(path="list")
	 * @return ResponseInterface
	 */
	public function index(): ResponseInterface
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
	 * @param BookValidate $validate
	 * @return ResponseInterface
	 */
	public function create(BookValidate $validate): ResponseInterface
	{
		$createResult = $this->service->serviceCreate($this->request->all());

		return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}

	/**
	 * @PostMapping(path="update")
	 * @param BookValidate $validate
	 * @return ResponseInterface
	 */
	public function update(BookValidate $validate): ResponseInterface
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