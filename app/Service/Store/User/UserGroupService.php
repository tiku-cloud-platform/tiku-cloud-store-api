<?php
declare(strict_types = 1);

namespace App\Service\Store\User;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\User\PlatformUserGroupRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户分组
 *
 * Class UserGroupService
 * @package App\Service\Store\User
 */
class UserGroupService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var PlatformUserGroupRepository
     */
    protected $groupRepository;

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
            if (!empty($title)) {
                $query->where('title', 'like', '%' . $title . '%');
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
        return $this->groupRepository->repositorySelect(
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
        $requestParams['uuid']       = UUID::getUUID();
        $requestParams['store_uuid'] = UserInfo::getStoreUserInfo()['store_uuid'];

        return $this->groupRepository->repositoryCreate((array)$requestParams);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        return $this->groupRepository->repositoryUpdate((array)[['uuid', '=', $requestParams['uuid']]], (array)[
            'title'   => trim($requestParams['title']),
            'is_show' => $requestParams['is_show'],
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
        $uuidArray   = explode(',', $requestParams['uuid']);
        $deleteWhere = [];
        foreach ($uuidArray as $value) {
            array_push($deleteWhere, $value);
        }

        return $this->groupRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->groupRepository->repositoryFind(self::searchWhere((array)$requestParams));
    }

    /**
     * 绑定用户
     * @param array $requestParams
     * @return int
     */
    public function serviceBindUser(array $requestParams): int
    {
        $userWhere         = [];
        $userRequestParams = json_decode($requestParams['user'], true);
        foreach ($userRequestParams as $value) {
            array_push($userWhere, $value);
        }

        return $this->groupRepository->repositoryBindUser((array)$userWhere, (array)[
            'group_uuid' => $requestParams['uuid'],
        ]);
    }
}