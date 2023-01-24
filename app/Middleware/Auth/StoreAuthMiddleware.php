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

namespace App\Middleware\Auth;

use App\Constants\CacheKey;
use App\Constants\ErrorCode;
use App\Constants\HttpCode;
use App\Mapping\HttpDataResponse;
use App\Mapping\RedisClient;
use App\Mapping\UserInfo;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 商户鉴权中间件
 *
 * Class StoreAuthMiddleware
 */
class StoreAuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var HttpDataResponse
     */
    protected $httpResponse;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authentication = $request->getHeader('Authentication', '');
        if (!empty($authentication)) {
            $userInfo = RedisClient::getInstance()->get(CacheKey::STORE_LOGIN_PREFIX . $authentication[0]);
            var_dump($userInfo, $authentication);
            if (!empty($userInfo)) {
                Context::set("login_info", json_decode($userInfo, true));
                return $handler->handle($request);
            }
        }
        return $this->httpResponse->response((string)ErrorCode::getMessage(ErrorCode::REQUEST_INVALID), ErrorCode::REQUEST_INVALID, [], HttpCode::NO_AUTH);
    }
}
