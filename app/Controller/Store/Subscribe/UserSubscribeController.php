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
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/subscribe/wechat")
 * Class UserSubscribeController
 * Author 卡二条
 * Email 2665274677@qq.com
 * Date 2021/9/20
 * @package App\Controller\Store\Subscribe
 */
class UserSubscribeController extends StoreBaseController
{
    public function __construct(UserSubscribeService $subscribeService)
    {
        $this->service = $subscribeService;
        parent::__construct($subscribeService);
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