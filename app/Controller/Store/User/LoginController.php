<?php
declare(strict_types = 1);

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
    /**
     * @PostMapping(path="user/login")
     * @return ResponseInterface
     */
    public function login()
    {
        $bean = (new StoreUserService)->serviceLogin($this->request->all());
        if ($bean['code'] == 1) {
            return $this->httpResponse->success((array)$bean['data']);
        }
        return $this->httpResponse->response((string)$bean['msg'], 0, []);
    }
}
