<?php
declare(strict_types = 1);

namespace App\Controller\Config;

use App\Controller\StoreBaseController;
use App\Request\Common\UUIDValidate;
use App\Request\Config\PageValidate;
use App\Service\Config\PageService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\Auth\StoreAuthMiddleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 商户页面
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="page")
 * Class MenuController
 * @package App\Controller\Store\Config
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

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate): ResponseInterface
    {
        $bean = (new PageService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="create")
     * @param PageValidate $validate
     * @return ResponseInterface
     */
    public function create(PageValidate $validate): ResponseInterface
    {
        $createResult = (new PageService)->serviceCreate($this->request->all());
        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="update")
     * @param PageValidate $validate
     * @return ResponseInterface
     */
    public function update(PageValidate $validate): ResponseInterface
    {
        $updateResult = (new PageService)->serviceUpdate($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy(): ResponseInterface
    {
        $deleteResult = (new PageService)->serviceDelete($this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}