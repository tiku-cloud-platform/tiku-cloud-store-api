<?php
declare(strict_types = 1);

namespace App\Service\Exam;

use App\Library\File\FileUpload;
use App\Library\File\ImageSrcSearch;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Exam\CollectionRepository;
use App\Repository\Exam\ReadingCollectionRelationRepository;
use App\Repository\Exam\ReadingRepository;
use App\Service\StoreServiceInterface;

/**
 * 阅读理解试题
 *
 * Class ReadingService
 * @package App\Service\Store\Exam
 */
class ReadingService implements StoreServiceInterface
{
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
            if (!empty($is_show)) {
                $query->where('is_show', '=', $is_show);
            }
            if (!empty($is_search)) {
                $query->where("is_search", "=", $is_search);
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
        return (new ReadingRepository)->repositorySelect(self::searchWhere($requestParams),
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
        $imageArray = ImageSrcSearch::searchImageUrl((string)$requestParams['content']);
        if (!empty($imageArray)) {
            $remoteFileArray          = (new FileUpload())->fileUpload($imageArray);
            $requestParams['content'] = ImageSrcSearch::replaceImageUrl((string)$requestParams['content'], $remoteFileArray);
        }

        $userInfo                    = UserInfo::getStoreUserInfo();
        $requestParams['store_uuid'] = $userInfo['store_uuid'];
        $requestParams['uuid']       = UUID::getUUID();

        return (new ReadingRepository)->repositoryCreate($requestParams);
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
        $imageArray = ImageSrcSearch::searchImageUrl((string)$requestParams['content']);
        if (!empty($imageArray)) {
            $remoteFileArray          = (new FileUpload())->fileUpload($imageArray);
            $requestParams['content'] = ImageSrcSearch::replaceImageUrl((string)$requestParams['content'], $remoteFileArray);
        }

        return (new ReadingRepository)->repositoryUpdate([
            ['uuid', '=', $requestParams['uuid']],
            ['store_uuid', '=', UserInfo::getStoreUserInfo()['store_uuid']]// 绑定关联使用
        ], $requestParams);
    }

    /**
     * 更新基础字段
     * @param array $requestParams
     * @return int
     */
    public function serviceEdit(array $requestParams): int
    {
        $uuid = $requestParams["uuid"];
        unset($requestParams["uuid"]);
        return (new ReadingRepository)->repositoryEdit([
            ["uuid", "=", $uuid],
            ["store_uuid", "=", UserInfo::getStoreUserInfo()['store_uuid']]
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

        return (new ReadingRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    /**
     * 查询总条数
     *
     * @param array $requestParams
     * @return int
     */
    public function serviceCount(array $requestParams = []): int
    {
        return (new ReadingRepository)->repositoryCount(self::searchWhere($requestParams));
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return (new ReadingRepository)->repositoryFind(self::searchWhere($requestParams));
    }

    /**
     * 验证试卷最大阅读试题
     * @param array $collectionArray 试卷uuid
     * @param string $uuid 当前试题uuid, 用户更新时验证排除当前uuid的计算
     * @return array 试卷信息
     */
    public function verifyCollectionSum(array $collectionArray, string $uuid = ""): array
    {
        $collectionRelationRepository = new ReadingCollectionRelationRepository();
        $collectionRepository         = new CollectionRepository();
        $returnMsg                    = ["uuid" => "", "msg" => ""];
        if (empty($collectionArray)) {
            return $returnMsg;
        }
        foreach ($collectionArray as $value) {
            $examSum = $collectionRelationRepository->repositoryWhereInCount("collection_uuid", [$value]);
            $bean    = $collectionRepository->repositoryFind(function ($query) use ($value) {
                $query->where("uuid", "=", $value);
            });

            if (!empty($bean) && $uuid == "" && $bean["max_reading_total"] <= $examSum) {
                $returnMsg["uuid"]   = $value;
                $returnMsg["msg"]    = $bean["title"];
                $returnMsg["status"] = 1;
                break;
            } elseif (!empty($bean) && $uuid != "" && $bean["max_reading_total"] < $examSum - 1) {
                $returnMsg["uuid"]   = $value;
                $returnMsg["msg"]    = $bean["title"];
                $returnMsg["status"] = 2;
                break;
            }
        }

        return $returnMsg;
    }
}