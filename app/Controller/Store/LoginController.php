<?php
declare(strict_types = 1);

namespace App\Controller\Store;

use App\Controller\StoreBaseController;
use App\Service\Store\UserService;
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
     * @PostMapping(path="login")
     * @return ResponseInterface
     */
    public function login()
    {
        $bean = (new UserService)->serviceLogin($this->request->all());
        if ($bean['code'] == 1) {
            return $this->httpResponse->success((array)$bean['data']);
        }
        return $this->httpResponse->response((string)$bean['msg'], 0, []);
    }
}
