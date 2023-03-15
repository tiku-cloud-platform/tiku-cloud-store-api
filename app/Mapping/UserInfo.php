<?php
declare(strict_types = 1);


namespace App\Mapping;

use Hyperf\Utils\Context;

/**
 * 用户信息管理
 * Class UserInfo
 */
class UserInfo
{
    public static function getStoreUserInfo(): array
    {
        $userInfo = Context::get("login_info");
        if (!empty($userInfo)) return $userInfo;
        return [];
    }

    public static function getStoreUserStoreUuid(): string
    {
        $userInfo = Context::get("login_info");
        if (!empty($userInfo)) return $userInfo["store_uuid"];
        return "";
    }
}
