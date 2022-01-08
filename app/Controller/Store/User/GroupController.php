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
    public function __construct(UserGroupService $groupService)
    {
        $this->service = $groupService;
        parent::__construct($groupService);
    }

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = $this->service->serviceSelect((array)$this->request->all());

        return $this->httpResponse->success((array)$items);
    }

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = $this->service->serviceFind((array)$this->request->all());

        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="create")
     * @param UserGroupValidate $validate
     * @return ResponseInterface
     */
    public function create(UserGroupValidate $validate)
    {
        $createResult = $this->service->serviceCreate((array)$this->request->all());

        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="update")
     * @param UserGroupValidate $validate
     * @return ResponseInterface
     */
    public function update(UserGroupValidate $validate)
    {
        $updateResult = $this->service->serviceUpdate((array)$this->request->all());

        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = $this->service->serviceDelete((array)$this->request->all());

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
        $bindResult = $this->service->serviceBindUser((array)$this->request->all());

        return $bindResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}