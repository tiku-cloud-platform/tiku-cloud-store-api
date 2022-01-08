<?php

declare(strict_types = 1);
/**
 * This file is part of api
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Controller\Api\User;

use App\Controller\UserBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Request\Api\User\UpdateInfoValidate;
use App\Service\User\User\WeChatUserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户中心
 *
 * @Controller(prefix="api/v1/user")
 * Class WeChatUserController
 * @package App\Controller\Api\User
 */
class WeChatUserController extends UserBaseController
{
    public function __construct(WeChatUserService $userService)
    {
        $this->service = $userService;
        parent::__construct($userService);
    }

    /**
     * @GetMapping(path="info")
     * @return ResponseInterface
     */
    public function show(): ResponseInterface
    {
        $userInfo = $this->service->serviceFind((array)$this->request->all());

        return $this->httpResponse->success((array)$userInfo);
    }

    /**
     * @Middleware(UserAuthMiddleware::class)
     * @PutMapping(path="update")
     * @param UpdateInfoValidate $validate
     * @return ResponseInterface
     */
    public function update(UpdateInfoValidate $validate): ResponseInterface
    {
        $updateResult = $this->service->serviceUpdate((array)$validate->validated());

        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->success();
    }

    /**
     * @Middleware(UserAuthMiddleware::class)
     * @PostMapping(path="check_login")
     * @return ResponseInterface
     */
    public function checkLogin(): ResponseInterface
    {
        return $this->httpResponse->success();
    }
}
