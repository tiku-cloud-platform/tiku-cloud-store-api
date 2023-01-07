<?php
declare(strict_types = 1);

namespace App\Controller\Store\User;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\User\BindUserValidate;
use App\Request\Store\User\UserGroupValidate;
use App\Service\Store\User\UserGroupService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户分组
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/user/group")
 * Class NoticeController
 * @package App\Controller\Store\Notice
 */
class GroupController extends StoreBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = (new UserGroupService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = (new UserGroupService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="create")
     * @param UserGroupValidate $validate
     * @return ResponseInterface
     */
    public function create(UserGroupValidate $validate)
    {
        $createResult = (new UserGroupService)->serviceCreate($this->request->all());
        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="update")
     * @param UserGroupValidate $validate
     * @return ResponseInterface
     */
    public function update(UserGroupValidate $validate)
    {
        $updateResult = (new UserGroupService)->serviceUpdate($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = (new UserGroupService)->serviceDelete($this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * 绑定用户
     * @PostMapping(path="bind_user")
     * @param BindUserValidate $userValidate
     * @return ResponseInterface
     */
    public function bindUser(BindUserValidate $userValidate)
    {
        $bindResult = (new UserGroupService)->serviceBindUser($this->request->all());
        return $bindResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}