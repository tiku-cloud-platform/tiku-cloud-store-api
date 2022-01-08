<?php

declare(strict_types=1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Controller\Store\File;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\Store\File\TokenService;
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
	public function __construct(TokenService $tokenService)
	{
		$this->service = $tokenService;
		parent::__construct($tokenService);
	}

	/**
	 * 第三方云存储token.
	 *
	 * @PostMapping(path="cloud_storage/token")
	 * @return ResponseInterface
	 */
	public function cloudStorageToken()
	{
		$bean = $this->service->serviceUploadToken();

		return !empty($bean['driver']) ? $this->httpResponse->success($bean) : $this->httpResponse->response((string)'你还未添加任何文件存储方式');
	}
}
