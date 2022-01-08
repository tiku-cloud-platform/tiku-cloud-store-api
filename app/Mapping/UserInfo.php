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

    public function getStoreLoginToken(): string
    {
        return $this->request->header('Authentication', '');
    }

    public function getWeChatLoginToken(): string
    {
        return $this->request->header('Authentication', '');
    }

    /**
     * 获取商户端登录信息
     *
     * @return array
     */
    public static function getStoreUserInfo(): array
    {
        $token = (new self())->getStoreLoginToken();
        if (!empty($token)) return (new RedisClient)->get((string)CacheKey::STORE_LOGIN_PREFIX, (string)$token);
        return [];
    }

    /**
     * 获取微信客户端登录信息
     *
     * @return array
     */
    public static function getWeChatUserInfo(): array
    {
        $userAgent = (new self())->request->header('User-Agent', 'asdadsf');

        $token = (new self())->getWeChatLoginToken();
        if (!empty($token)) {
            $userInfo = (new RedisClient)->get((string)CacheKey::USER_LOGIN_PREFIX, (string)$token);
            if (!empty($userInfo)) return $userInfo;
            return [];
        }

        return [];
    }
}
