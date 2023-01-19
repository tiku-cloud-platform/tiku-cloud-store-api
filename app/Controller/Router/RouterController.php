<?php
declare(strict_types = 1);

namespace App\Controller\Router;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\User\UserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;

/**
 * 商户端菜单
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/router")
 * Class NoticeController
 * @package App\Controller\Store\Notice
 */
class RouterController extends StoreBaseController
{
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
        parent::__construct($userService);
    }

    /**
     * @GetMapping(path="list")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        $routerList = [
            ["paht" => "/store", "name" => "菜单一", "component" => "Layout", "redirect" => "/store", "hidden" => true, "children" => [
                ["paht" => "/store", "name" => "菜单一1", "component" => "Layout", "redirect" => "/store", "hidden" => true, "meta" => ["title" => "菜单名称", "icon" => "table"]],
                ["paht" => "/store", "name" => "菜单一1", "component" => "Layout", "redirect" => "/store", "hidden" => true],
                ["paht" => "/store", "name" => "菜单一1", "component" => "function() { import('@/views/user/wechat') }", "redirect" => "/store", "hidden" => true],
                ["paht" => "/store", "name" => "菜单一1", "component" => "function() { import('@/views/user/wechat') }", "redirect" => "/store", "hidden" => true],
                ["paht" => "/store", "name" => "菜单一1", "component" => "Layout", "redirect" => "/store", "hidden" => true],
                ["paht" => "/store", "name" => "菜单一1", "component" => "function() { import('@/views/user/wechat') }", "redirect" => "/store", "hidden" => true],
                ["paht" => "/store", "name" => "菜单一1", "component" => "Layout", "redirect" => "/store", "hidden" => true],
            ]]
        ];
        $router     = [
            'items' => $routerList,
            'total' => 1,
            'size'  => 10,
            'page'  => 1,
        ];
        return $this->httpResponse->success((array)$router);
    }
}