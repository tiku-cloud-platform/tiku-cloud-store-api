<?php

declare(strict_types = 1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Controller\Store\User;

use App\Controller\StoreBaseController;
use App\Service\Store\User\StoreUserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 商户登录.
 *
 * @Controller(prefix="store")
 * Class LoginController
 */
class LoginController extends StoreBaseController
{
    public function __construct(StoreUserService $userService)
    {
        $this->service = $userService;
        parent::__construct($userService);
    }

    /**
     * @PostMapping(path="user/login")
     * @return ResponseInterface
     */
    public function login()
    {
        $bean = $this->service->serviceLogin((array)$this->request->all());

        if ($bean['code'] == 1) {
            return $this->httpResponse->success((array)$bean['data']);
        }

        return $this->httpResponse->response((string)$bean['msg'], (int)0, (array)[]);
    }
}
