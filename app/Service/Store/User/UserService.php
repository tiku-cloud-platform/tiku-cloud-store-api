<?php
declare(strict_types = 1);

namespace App\Service\Store\User;


use App\Repository\Store\User\StorePlatformUserRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台用户
 *
 * Class UserService
 * @package App\Service\Store\User
 */
class UserService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var StorePlatformUserRepository
     */
    protected $userRepository;

    public function __construct()
    {
    }

    /**
     * 格式化查询条件
     *
     * @param array $requestParams 请求参数
     * @return mixed 组装的查询条件
     */
    public static function searchWhere(array $requestParams)
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
            if (!empty($group_uuid)) {
                $query->where('store_platform_user_group_uuid', '=', $group_uuid);
            }
            if (!empty($nickname)) {
                $query->where('nickname', 'like', '%' . $nickname . '%');
            }
            if (!empty($mobile)) {
                $query->where('mobile', 'like', '%' . $mobile . '%');
            }
            if (!empty($start_time)) {
                $query->where('created_at', '>=', $start_time);
            }
            if (!empty($end_time)) {
                $query->where('created_at', '<=', $end_time);
            }
        };
    }

    /**
     * 查询数据
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        return $this->userRepository->repositorySelect(
            self::searchWhere((array)$requestParams),
            (int)$requestParams['size'] ?? 20
        );
    }

    /**
     * 创建数据
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {

    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        return $this->userRepository->repositoryUpdate((array)[
            ['uuid', '=', trim($requestParams['uuid'])],
        ], (array)[
            'is_forbidden' => trim($requestParams['is_forbidden'])
        ]);
    }

    /**
     * 删除数据
     *
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams): int
    {

    }

    /**
     * 查询该主账号下的所有子账号
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        // 1. 微信小程序账号信息
        $miniWeChatUser = (new WeChatUserService())->serviceSelect((array)$requestParams);

        return [
            'items' => $this->formatterList((array)$miniWeChatUser['items']),
            'total' => 1,
            'size'  => 1,
            'page'  => 1,
        ];
    }

    /**
     * 查询用户总数
     *
     * @param array $requestParams
     * @return int
     */
    public function serviceCount(array $requestParams = []): int
    {
        return $this->userRepository->repositoryCount(self::searchWhere((array)$requestParams));
    }

    /**
     * 查询每日新增用户
     *
     * @param array $requestParams
     * @return array
     */
    public function serviceEveryDayRegister(array $requestParams = []): array
    {
        return $this->userRepository->repositoryEveryDayCount(self::searchWhere((array)$requestParams));
    }

    /**
     * 查询每日用户总数
     * @param array $requestParams
     * @return array
     */
    public function serviceEveryDayTotal(array $requestParams = []): array
    {
        foreach ($requestParams as $key => $value) {
            $requestParams[$key]['number'] = $this->userRepository->repositoryEveryDayTotal((string)$value['date']);
        }

        return $requestParams;
    }

    /**
     * 用户数据格式化
     * @param array $weChatMini
     * @return array
     */
    private function formatterList(array $weChatMini): array
    {
        $items = [];
        foreach ($weChatMini as $key => $value) {
            $items[$key] = [
                'uuid'         => $value->uuid,
                'store_uuid'   => $value->store_uuid,
                'openid'       => $value->openid,
                'nickname'     => $value->nickname,
                'avatar_url'   => $value->avatar_url,
                'address'      => $value->country . $value->province . $value->city . $value->district,
                'is_forbidden' => $value->is_forbidden,
                'real_name'    => $value->real_name,
                'mobile'       => $value->mobile,
                'gender'       => $value->gender,
                'user_uuid'    => $value->user_uuid,
                'platform'     => '微信小程序',
                'created_at'   => date('Y-m-d H:i:s', strtotime((string)$value->created_at)),
            ];
        }

        return $items;
    }
}