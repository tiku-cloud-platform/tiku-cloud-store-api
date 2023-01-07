<?php
declare(strict_types = 1);

namespace App\Controller\Store\Page;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\Store\Page\PageService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户端页面
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/page")
 * Class PageController
 * @package App\Controller\Store\Page
 */
class PageController extends StoreBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = (new PageService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}