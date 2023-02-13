<?php
declare(strict_types = 1);

namespace App\Controller\User;

use App\Controller\StoreBaseController;
use App\Mapping\UserInfo;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\Score\ScoreHistoryService;
use App\Service\User\UserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 平台用户
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="user")
 * Class UserController
 * @package App\Controller\Store\User
 */
class UserController extends StoreBaseController
{
    /**
     * 平台用户列表
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = (new UserService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * 平台用户汇总信息
     * @GetMapping(path="all/info")
     * @return ResponseInterface
     */
    public function allInfo(): ResponseInterface
    {
        return $this->httpResponse->success((new UserService())->serviceFind($this->request->all()));
    }

    /**
     * 积分明细
     * @GetMapping(path="score/list")
     * @return ResponseInterface
     */
    public function score(): ResponseInterface
    {
        $items = (new ScoreHistoryService())->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}