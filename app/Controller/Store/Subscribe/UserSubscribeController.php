<?php
declare(strict_types = 1);

namespace App\Controller\Store\Subscribe;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\Store\Subscribe\UserSubscribeService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 微信用户订阅消息
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/subscribe/wechat")
 * Class UserSubscribeController
 * @package App\Controller\Store\Subscribe
 */
class UserSubscribeController extends StoreBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = (new UserSubscribeService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}