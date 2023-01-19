<?php
declare(strict_types = 1);

namespace App\Controller\File;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\File\TokenService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 文件token处理
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/file")
 * Class TokenController
 */
class TokenController extends StoreBaseController
{
    /**
     * 第三方云存储token
     * @PostMapping(path="cloud_storage/token")
     * @return ResponseInterface
     */
    public function cloudStorageToken(): ResponseInterface
    {
        $bean = (new TokenService)->serviceUploadToken();
        return !empty($bean['driver']) ? $this->httpResponse->success($bean) : $this->httpResponse->response((string)'你还未添加任何文件存储方式');
    }
}
