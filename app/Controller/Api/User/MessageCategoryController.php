<?php
declare(strict_types=1);

namespace App\Controller\Api\User;


use App\Controller\UserBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Service\User\User\MessageCategoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 平台消息分类
 *
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 *     })
 * @Controller(prefix="api/v1/user/message/category")
 * Class MessageCategoryController
 * @package App\Controller\Api\User
 */
class MessageCategoryController extends UserBaseController
{
	public function __construct(MessageCategoryService $categoryService)
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
}