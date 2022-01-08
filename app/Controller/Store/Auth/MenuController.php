<?php
declare(strict_types = 1);

namespace App\Controller\Store\Auth;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\Store\Article\ArticleService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 商户菜单
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/auth")
 * Class MenuController
 * @package App\Controller\Store\Auth
 */
class MenuController extends StoreBaseController
{
    public function __construct(ArticleService $articleService)
    {
        $this->service = $articleService;
        parent::__construct($articleService);
    }

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $menu = config('menu');
        return $this->httpResponse->success((array)$menu);
    }
}