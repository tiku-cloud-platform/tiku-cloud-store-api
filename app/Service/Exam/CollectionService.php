<?php
declare(strict_types = 1);

namespace App\Service\Exam;


use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Exam\CollectionRepository;
use App\Repository\Exam\ReadingRepository;
use App\Service\StoreServiceInterface;

/**
 * 试卷
 * Class CategoryService
 * @package App\Service\Store\Exam
 */
class CollectionService implements StoreServiceInterface
{
    /**
     * 格式化查询条件
     * @param array $requestParams 请求参数
     * @return \Closure 组装的查询条件
     */
    public static function searchWhere(array $requestParams)
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
            if (!empty($is_recommend)) {
                $query->where('is_recommend', '=', $is_recommend);
            }
            if (!empty($is_show)) {
                $query->where('is_show', '=', $is_show);
            }
            if (!empty($exam_category_uuid)) {
                $query->where('exam_category_uuid', '=', $exam_category_uuid);
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
        return (new CollectionRepository)->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
    }

    /**
     * 查询数据
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceRelationSelect(array $requestParams): array
    {
        return (new CollectionRepository)->repositoryRelationSelect(self::searchWhere($requestParams),
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
        $userInfo                    = UserInfo::getStoreUserInfo();
        $requestParams['store_uuid'] = $userInfo['store_uuid'];
        $requestParams['uuid']       = UUID::getUUID();

        return (new CollectionRepository)->repositoryCreate($requestParams);

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
        return (new CollectionRepository)->repositoryUpdate([
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

        return (new CollectionRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return (new CollectionRepository)->repositoryFind(self::searchWhere($requestParams));
    }

    /**
     * 查询总条数
     *
     * @param array $requestParams
     * @return int
     */
    public function serviceCount(array $requestParams = []): int
    {
        return (new CollectionRepository)->repositoryCount(self::searchWhere($requestParams));
    }

    /**
     * 查询提交总数
     *
     * @param array $requestParams
     * @return int
     */
    public function serviceSum(array $requestParams = []): int
    {
        return (new CollectionRepository)->repositorySum(self::searchWhere($requestParams), 'submit_number');
    }

    /**
     * 查询阅读理解列表
     * @param array $requestParams
     * @return array
     */
    public function serviceReadingList(array $requestParams): array
    {
        return (new ReadingRepository())->repositoryQuery([[""]]);
    }
}