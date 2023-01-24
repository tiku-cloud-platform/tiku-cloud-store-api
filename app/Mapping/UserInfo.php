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

namespace App\Mapping;

use App\Constants\CacheKey;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;

/**
 * 用户信息管理
 *
 * Class UserInfo
 */
class UserInfo
{
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    public function getWeChatLoginToken(): string
    {
        return $this->request->header('Authentication', '');
    }

    /**
     * 获取商户端登录信息
     * @return array
     */
    public static function getStoreUserInfo(): array
    {
        $userInfo = Context::get("login_info");
        if (!empty($userInfo)) return $userInfo;
        return [];
    }

    /**
     * 获取微信客户端登录信息
     * @return array
     */
    public static function getWeChatUserInfo(): array
    {
        $userAgent = (new self())->request->header('User-Agent', 'asdadsf');
        $token     = (new self())->getWeChatLoginToken();
        if (!empty($token)) {
            $userInfo = (new RedisClient)->get(CacheKey::USER_LOGIN_PREFIX, $token);
            if (!empty($userInfo)) return $userInfo;
            return [];
        }

        return [];
    }
}
