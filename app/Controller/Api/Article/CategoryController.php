<?php
declare(strict_types=1);

namespace App\Controller\Api\Article;


use App\Controller\UserBaseController;
use App\Service\User\Article\CategoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 文章分类
 *
 * @Controller(prefix="api/v1/article/category")
 * Class CategoryController
 * @package App\Controller\Api\Article
 */
class CategoryController extends UserBaseController
{
	public function __construct(CategoryService $categoryService)
	{
		$this->service = $categoryService;
		parent::__construct($categoryService);
	}

	/**
	 * @GetMapping(path="list")
	 * @return ResponseInterface
	 * @author kert
	 */
	public function index()
	{
		$items = $this->service->serviceSelect((array)$this->request->all());

		return $this->httpResponse->success((array)$items);
	}
}