<?php
declare(strict_types = 1);

namespace App\Service\Config;


use App\Library\File\FileUpload;
use App\Library\File\ImageSrcSearch;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Config\PlatformContentRepository;
use App\Service\StoreServiceInterface;

/**
 * 平台内容介绍
 *
 * Class PlatformContentService
 * @package App\Service\Store\Config
 */
class PlatformContentService implements StoreServiceInterface
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
            if (!empty($position)) {
                $query->where('position', 'like', "%" . $position . "$%");
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
        return (new PlatformContentRepository)->repositorySelect(
            self::searchWhere($requestParams),
            (int)($requestParams['size'] ?? 20)
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
        $imageArray = ImageSrcSearch::searchImageUrl((string)$requestParams['content']);
        if (!empty($imageArray)) {
            $remoteFileArray          = (new FileUpload())->fileUpload($imageArray);
            $requestParams['content'] = ImageSrcSearch::replaceImageUrl((string)$requestParams['content'], $remoteFileArray);
        }

        $requestParams['uuid']       = UUID::getUUID();
        $requestParams['store_uuid'] = UserInfo::getStoreUserInfo()['store_uuid'];

        return (new PlatformContentRepository)->repositoryCreate($requestParams);
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

        return (new PlatformContentRepository)->repositoryUpdate([
            ['uuid', '=', trim($requestParams['uuid'])],
        ], [
            'title' => trim($requestParams['title']),
            'is_show' => in_array($requestParams['is_show'], [1, 2]) ? $requestParams["is_show"] : 2,
            'content' => $requestParams['content'],
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

        return (new PlatformContentRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return (new PlatformContentRepository)->repositoryFind(self::searchWhere($requestParams));
    }
}