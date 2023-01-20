<?php
declare(strict_types = 1);

namespace App\Controller\Config;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Common\UUIDValidate;
use App\Request\Config\MenuValidate;
use App\Service\Config\MenuService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户端菜单配置
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/config")
 * Class MenuController
 * @package App\Controller\Store\Config
 */
class MenuController extends StoreBaseController
{
    /**
     * @GetMapping(path="menu/list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = (new MenuService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="menu/show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = (new MenuService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="menu/create")
     * @param MenuValidate $validate
     * @return ResponseInterface
     */
    public function create(MenuValidate $validate)
    {
        $createResult = (new MenuService)->serviceCreate($this->request->all());
        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="menu/update")
     * @param MenuValidate $validate
     * @return ResponseInterface
     */
    public function update(MenuValidate $validate)
    {
        $updateResult = (new MenuService)->serviceUpdate($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="menu/delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = (new MenuService)->serviceDelete($this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}