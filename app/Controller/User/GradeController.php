<?php
declare(strict_types = 1);

namespace App\Controller\User;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\User\BindUserValidate;
use App\Request\Store\User\UserGroupValidate;
use App\Service\User\GradeService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户会员等级
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="user/grade")
 * Class NoticeController
 * @package App\Controller\Store\Notice
 */
class GradeController extends StoreBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = (new GradeService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = (new GradeService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="create")
     * @param UserGroupValidate $validate
     * @return ResponseInterface
     */
    public function create(UserGroupValidate $validate)
    {
        $createResult = (new GradeService)->serviceCreate($this->request->all());
        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="update")
     * @param UserGroupValidate $validate
     * @return ResponseInterface
     */
    public function update(UserGroupValidate $validate)
    {
        $updateResult = (new GradeService)->serviceUpdate($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy(): ResponseInterface
    {
        $deleteResult = (new GradeService)->serviceDelete($this->request->all());
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
        $bindResult = (new GradeService)->serviceBindUser($this->request->all());
        return $bindResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}