<?php
declare(strict_types = 1);

namespace App\Controller\Store\User;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\User\WeChatUserValidate;
use App\Service\Store\User\UserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 平台用户
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/user")
 * Class UserController
 * @package App\Controller\Store\User
 */
class UserController extends StoreBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = (new UserService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate): ResponseInterface
    {
        $bean = (new UserService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="create")
     * @return ResponseInterface
     */
    public function create()
    {

    }

    /**
     * @PutMapping(path="update")
     * @param WeChatUserValidate $validate
     * @return ResponseInterface
     */
    public function update(WeChatUserValidate $validate): ResponseInterface
    {
        $updateResult = (new UserService)->serviceUpdate($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy(): ResponseInterface
    {

    }
}