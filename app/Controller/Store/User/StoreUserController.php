<?php
declare(strict_types = 1);

namespace App\Controller\Store\User;

use App\Controller\StoreBaseController;
use App\Mapping\UserInfo;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\User\StoreUserValidate;
use App\Service\Store\User\StoreUserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 商户管理
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/user")
 * Class StoreUserController
 */
class StoreUserController extends StoreBaseController
{
    /**
     * 获取商户信息
     * @GetMapping(path="user_info")
     * @return ResponseInterface
     */
    public function show(): ResponseInterface
    {
        $userInfo = UserInfo::getStoreUserInfo();
        return $this->httpResponse->success($userInfo);
    }

    /**
     * 修改商户信息
     * @PutMapping(path="update_info")
     * @param StoreUserValidate $validate
     * @return ResponseInterface
     */
    public function update(StoreUserValidate $validate): ResponseInterface
    {
        $updateResult = (new StoreUserService)->serviceUpdate($this->request->all());
        if ($updateResult == -1) {
            return $this->httpResponse->response('原始密码不正确');
        } elseif ($updateResult) {
            return $this->httpResponse->success();
        }

        return $this->httpResponse->error();
    }

    /**
     * 退出登录
     * @DeleteMapping(path="login_out")
     * @return ResponseInterface
     */
    public function loginOut(): ResponseInterface
    {
        return $this->httpResponse->success();
    }
}
