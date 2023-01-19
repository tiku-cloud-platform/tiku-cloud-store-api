<?php
declare(strict_types = 1);

namespace App\Controller\Dictionary;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Dict\DictValidate;
use App\Service\Dictionary\DictService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 字典管理
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/dict")
 */
class DictController extends StoreBaseController
{
    /**
     * 通过分组code查询对应的字典
     * @GetMapping(path="list_group_code")
     * @return ResponseInterface
     */
    public function indexByGroupCode(): ResponseInterface
    {
        return $this->httpResponse->success((new DictService())->serviceByGroupCode($this->request->all()));
    }

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->httpResponse->success((new DictService())->serviceSelect($this->request->all()));
    }

    /**
     * @PostMapping(path="create")
     * @param DictValidate $validate
     * @return ResponseInterface
     */
    public function create(DictValidate $validate): ResponseInterface
    {
        if ((new DictService())->serviceCreate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="update")
     * @param DictValidate $validate
     * @return ResponseInterface
     */
    public function update(DictValidate $validate): ResponseInterface
    {
        if ((new DictService())->serviceUpdate($this->request->all())) {
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
        if ((new DictService())->serviceDelete($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }
}