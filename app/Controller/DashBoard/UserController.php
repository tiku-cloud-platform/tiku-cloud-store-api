<?php
declare(strict_types = 1);

namespace App\Controller\DashBoard;

use App\Controller\StoreBaseController;
use App\Service\DashBoard\UserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use App\Middleware\Auth\StoreAuthMiddleware;
use Psr\Http\Message\ResponseInterface;

/**
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 * })
 * @Controller(prefix="dashboard")
 */
class UserController extends StoreBaseController
{
    /**
     * 用户指标
     * @GetMapping(path="user")
     * @return ResponseInterface
     */
    public function user(): ResponseInterface
    {
        return $this->httpResponse->success((new UserService())->user());
    }
}