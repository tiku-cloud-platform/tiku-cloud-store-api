<?php
declare(strict_types = 1);

namespace App\Service\Store\User;

use App\Constants\CacheKey;
use App\Constants\CacheTime;
use App\Mapping\RedisClient;
use App\Mapping\UserInfo;
use App\Repository\Store\User\UserRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 商户平台用户.
 * Class StoreUserService
 */
class StoreUserService implements StoreServiceInterface
{
    /**
     * 格式化查询条件.
     * @param array $requestParams 请求参数
     * @return mixed 组装的查询条件
     */
    public static function searchWhere(array $requestParams)
    {
        return function () {
        };
    }

    /**
     * 查询数据.
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        return [];
    }

    /**
     * 创建数据.
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        return false;
    }

    /**
     * 更新数据.
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        $userInfo   = UserInfo::getStoreUserInfo();
        $updateInfo = [
            'name' => $requestParams['name'],
            'email' => $requestParams['email'],
            'mobile' => $requestParams['mobile'],
            'avatar' => $requestParams['avatar'],
        ];
        if (!empty($requestParams['new_password'])) {
            $oldPwd = md5(base64_decode($requestParams['old_password']) . env('PASSWORD_SALT'));
            if ($userInfo['password'] != $oldPwd) {// 旧密码不一致
                return -1;
            }
            $updateInfo['password'] = md5(base64_decode($requestParams['new_password']) . env('PASSWORD_SALT'));
        }

        $updateRow = (new UserRepository)->repositoryUpdate([
            ['uuid', '=', $userInfo['uuid']]
        ], $updateInfo);

        if ($updateRow && !empty($requestParams['new_password'])) {
            RedisClient::delete(CacheKey::STORE_LOGIN_PREFIX, (string)$userInfo['login_token']);
        }

        return $updateRow;
    }

    /**
     * 删除数据.
     *
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    /**
     * 查询单条数据.
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return (new UserRepository)->repositoryFind(function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($username)) {
                $query->where('login_number', '=', $username);
            }
        });
    }

    /**
     * 用户登录处理.
     *
     * @return array['code' => [1, 2, 3, 4], 'msg' => [登录成功, '账号已过期', '密码不正确', '登录账号不存在']， 'data' => []]
     */
    public function serviceLogin(array $requestParams): array
    {
        $userInfo = (new UserRepository)->repositoryFind(function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($username)) {
                $query->where('login_number', '=', $username);
            }
        });
        $data     = ['code' => 4, 'msg' => '账号或密码不正确', 'data' => $userInfo];
        if (!empty($userInfo)) {
            // 账号过期
            if (strtotime($userInfo['expire_time']) < time()) {
                $data['code'] = 2;
                $data['msg']  = '账号已过期 请联系客服处理';
                return $data;
            }
            // 登录密码不正确
            if ($userInfo['password'] != md5(base64_decode($requestParams['password']) . env('PASSWORD_SALT'))) {
                var_dump($userInfo['password'], md5(base64_decode($requestParams['password']) . env('PASSWORD_SALT')));
                $data['code'] = 3;
                $data['data'] = [
                    $userInfo['password'],
                    md5(base64_decode($requestParams['password'] ?? null) . env('PASSWORD_SALT')),
                ];
                return $data;
            }
            $data['code'] = 1;
            $data['msg']  = '登录成功';
            // 生成token
            $token                   = md5((string)time());
            $userInfo['login_token'] = $token;
            RedisClient::create(CacheKey::STORE_LOGIN_PREFIX, $token, $userInfo, CacheTime::STORE_LOGIN_EXPIRE_TIME);
            // token保存在数据库中
            (new UserRepository)->repositoryUpdate([['uuid', '=', $userInfo['uuid']]], ['remember_token' => $token]);
            // 删除之前的token信息
            RedisClient::delete(CacheKey::STORE_LOGIN_PREFIX, (string)$userInfo['remember_token']);
            // 返回数据
            $userInfo['login_token'] = $token;
            $data['data']            = $userInfo;
        }

        return $data;
    }
}
