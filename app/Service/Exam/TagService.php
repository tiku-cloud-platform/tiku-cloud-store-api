<?php
declare(strict_types = 1);

namespace App\Service\Exam;


use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Exam\TagRepository;
use App\Service\StoreServiceInterface;
use Closure;

/**
 * 试题知识点
 *
 * Class TagService
 * @package App\Service\Store\Exam
 */
class TagService implements StoreServiceInterface
{
    /**
     * 格式化查询条件
     *
     * @param array $requestParams 请求参数
     * @return Closure 组装的查询条件
     */
    public static function searchWhere(array $requestParams): Closure
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
            };
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
        return (new TagRepository)->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
    }

    /**
     * 查询顶级分类
     *
     * @param array $requestParams
     * @return array
     */
    public function serviceParentSelect(array $requestParams): array
    {
        return (new TagRepository)->repositoryParentSelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
    }

    /**
     * 创建数据
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        $userInfo                     = UserInfo::getStoreUserInfo();
        $requestParams['store_uuid']  = $userInfo['store_uuid'];
        $requestParams['uuid']        = UUID::getUUID();
        $requestParams['parent_uuid'] = empty($requestParams['parent_uuid']) ? null : $requestParams['parent_uuid'];

        return (new TagRepository)->repositoryCreate($requestParams);

    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        unset($requestParams["creator"]);
        $requestParams['parent_uuid'] = empty($requestParams['parent_uuid']) ? null : $requestParams['parent_uuid'];
        return (new TagRepository)->repositoryUpdate([
            ['uuid', '=', $requestParams['uuid']]
        ], $requestParams);
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

        return (new TagRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return (new TagRepository)->repositoryFind(self::searchWhere($requestParams));
    }
}