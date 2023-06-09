<?php
declare(strict_types = 1);

namespace App\Service\User;

use App\Exception\DbDuplicateMessageException;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\User\GradeRepository;
use App\Repository\User\UserRepository;
use App\Service\StoreServiceInterface;

/**
 * 用户分组
 * Class UserGroupService
 * @package App\Service\Store\User
 */
class GradeService implements StoreServiceInterface
{
    /**
     * 格式化查询条件
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
            if (!empty($is_show)) {
                $query->where('is_show', '=', $is_show);
            }
            if (!empty($title)) {
                $query->where('title', 'like', '%' . $title . '%');
            }
        };
    }

    /**
     * 查询数据
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        return (new GradeRepository)->repositorySelect(
            self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20
        );
    }

    /**
     * 创建数据
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        $requestParams['uuid']       = UUID::getUUID();
        $requestParams['store_uuid'] = UserInfo::getStoreUserInfo()['store_uuid'];

        return (new GradeRepository)->repositoryCreate($requestParams);
    }

    /**
     * 更新数据
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        unset($requestParams["creator"]);
        return (new GradeRepository)->repositoryUpdate([['uuid', '=', $requestParams['uuid']]], [
            'title' => trim($requestParams['title']),
            'is_show' => $requestParams['is_show'],
            'is_default' => $requestParams['is_default'],
            'score' => $requestParams['score'],
            'remark' => $requestParams['remark'],
            'file_uuid' => $requestParams['file_uuid'],
        ]);
    }

    /**
     * 删除数据
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
        // 先查询是否存在被使用的会员等级
        $count = (new UserRepository())->repositoryCount(function ($query) use ($uuidArray) {
            $query->whereIn("store_platform_user_group_uuid", $uuidArray);
        });
        if ($count > 0) {
            throw new DbDuplicateMessageException("该等级下存在用户，无法进行删除");
        }
        return (new GradeRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    /**
     * 查询单条数据
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return (new GradeRepository)->repositoryFind(self::searchWhere($requestParams));
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

        return (new GradeRepository)->repositoryBindUser($userWhere, [
            'group_uuid' => $requestParams['uuid'],
        ]);
    }
}