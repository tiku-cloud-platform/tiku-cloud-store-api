<?php
declare(strict_types = 1);

namespace App\Controller\Dictionary;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Dict\GroupValidate;
use App\Service\Dictionary\GroupService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 字典分组管理
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/dict/group")
 */
class GroupController extends StoreBaseController
{
    /**
     * @GetMapping(path="all")
     * @return ResponseInterface
     */
    public function all(): ResponseInterface
    {
        return $this->httpResponse->success((new GroupService())->serviceAll($this->request->all()));
    }

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->httpResponse->success((new GroupService())->serviceSelect($this->request->all()));
    }

    /**
     * @PostMapping(path="create")
     * @param GroupValidate $validate
     * @return ResponseInterface
     */
    public function create(GroupValidate $validate): ResponseInterface
    {
        if ((new GroupService())->serviceCreate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="update")
     * @param GroupValidate $validate
     * @return ResponseInterface
     */
    public function update(GroupValidate $validate): ResponseInterface
    {
        if ((new GroupService())->serviceUpdate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy(): ResponseInterface
    {
        if ((new GroupService())->serviceDelete($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }
}