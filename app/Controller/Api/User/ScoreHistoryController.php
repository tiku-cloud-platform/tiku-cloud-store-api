<?php
declare(strict_types=1);

namespace App\Controller\Api\User;


use App\Controller\UserBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Service\User\User\ScoreHistoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户积分历史
 *
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 *     })
 * @Controller(prefix="api/v1/user/score")
 * Class ScoreHistoryController
 * @package App\Controller\Api\User
 */
class ScoreHistoryController extends UserBaseController
{
	public function __construct(ScoreHistoryService $scoreHistoryService)
	{
		$this->service = $scoreHistoryService;
		parent::__construct($scoreHistoryService);
	}

	/**
	 * 用户积分历史
	 *
	 * @GetMapping(path="list")
	 * @return ResponseInterface
	 */
	public function index()
	{
		$items = $this->service->serviceSelect((array)$this->request->all());

		return $this->httpResponse->success((array)$items);
	}
}