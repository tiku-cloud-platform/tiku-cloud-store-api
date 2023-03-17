<?php
declare(strict_types = 1);

namespace App\Controller\Attache;

use App\Controller\StoreBaseController;
use App\Request\Attache\CateValidate;
use App\Service\Attache\CateService;
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
 * 附件分类
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="attache_cate")
 * Class CategoryController
 * @package App\Controller\Store\Book
 */
class CateController extends StoreBaseController
{
    /**
     * @GetMapping(path="all")
     * @return ResponseInterface
     */
    public function all(): ResponseInterface
    {
        return $this->httpResponse->success((new CateService())->serviceAll());
    }

    /**
     * @GetMapping(path="tree")
     * @return ResponseInterface
     */
    public function tree(): ResponseInterface
    {
        return $this->httpResponse->success((new CateService())->serviceTree());
    }

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->httpResponse->success((new CateService())->serviceSelect($this->request->all()));
    }

    /**
     * @PostMapping(path="create")
     * @param CateValidate $validate
     * @return ResponseInterface
     */
    public function create(CateValidate $validate): ResponseInterface
    {
        if ((new CateService())->serviceCreate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="update")
     * @param CateValidate $validate
     * @return ResponseInterface
     */
    public function update(CateValidate $validate): ResponseInterface
    {
        if ((new CateService())->serviceUpdate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function delete(): ResponseInterface
    {
        if ((new CateService())->serviceDelete($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }
}