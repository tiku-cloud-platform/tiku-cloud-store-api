<?php
declare(strict_types=1);

namespace App\Controller\Api\User;


use App\Controller\UserBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Service\User\User\SignHistoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户签到
 *
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 *     })
 * @Controller(prefix="api/v1/user/sign")
 * Class SingController
 * @package App\Controller\Api\User
 */
class SignController extends UserBaseController
{
	public function __construct(SignHistoryService $signHistoryService)
	{
		$this->service = $signHistoryService;
		parent::__construct($signHistoryService);
	}

	/**
	 * @PostMapping(path="submit")
	 * @return ResponseInterface
	 */
	public function sign()
	{
		$signResult = $this->service->serviceCreate((array)$this->request->all());

		return $signResult ? $this->httpResponse->success() : $this->httpResponse->error();
	}
}