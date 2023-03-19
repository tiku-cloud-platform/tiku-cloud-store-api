<?php
declare(strict_types = 1);

namespace App\Controller\Attache;

use App\Controller\StoreBaseController;
use App\Request\Attache\AttacheValidate;
use App\Request\Attache\UuidValidate;
use App\Service\Attache\AttacheService;
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
 * 附件管理
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="attache")
 * Class AttacheController
 * @package App\Controller\Store\Book
 */
class AttacheController extends StoreBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->httpResponse->success((new AttacheService())->serviceSelect($this->request->all()));
    }

    /**
     * @PostMapping(path="create")
     * @param AttacheValidate $validate
     * @return ResponseInterface
     */
    public function create(AttacheValidate $validate): ResponseInterface
    {
        if ((new AttacheService())->serviceCreate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }

    /**
     * @GetMapping(path="show")
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function show(UuidValidate $validate): ResponseInterface
    {
        return $this->httpResponse->success((new AttacheService())->serviceFind($this->request->all()));
    }

    /**
     * @PutMapping(path="update")
     * @param AttacheValidate $validate
     * @return ResponseInterface
     */
    public function update(AttacheValidate $validate): ResponseInterface
    {
        if ((new AttacheService())->serviceUpdate($this->request->all())) {
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
        if ((new AttacheService())->serviceDelete($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }
}