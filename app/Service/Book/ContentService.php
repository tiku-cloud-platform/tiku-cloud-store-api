<?php
declare(strict_types = 1);

namespace App\Service\Book;

use App\Library\File\FileUpload;
use App\Library\File\ImageSrcSearch;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Book\CategoryRepository;
use App\Repository\Book\ContentRepository;
use App\Service\StoreServiceInterface;
use Closure;

/**
 * 书籍内容
 * @package App\Service\Store\Book
 */
class ContentService implements StoreServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            // 处理一级分类，查询所有子类。
            $categoryAll = (new CategoryRepository())->repositorySpecial([["store_book_uuid", "=", $store_book_uuid]], ["uuid"]);
            if (!empty($categoryAll)) {
                $categoryAll = array_column($categoryAll, "uuid");
            } else {
                $categoryAll = [];
            }
            array_push($categoryAll, $store_book_uuid);
            $query->whereIn('store_book_uuid', $categoryAll);
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
            if (!empty($store_book_category_uuid)) {
                // 一级分类和全部分类条件查询
                $query->where('store_book_category_uuid', '=', $store_book_category_uuid);
            }
            if (!empty($title)) {
                $query->where('title', 'like', '%' . $title . '%');
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new ContentRepository)->repositorySelect(
            self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20
        );
    }

    public function serviceCreate(array $requestParams): bool
    {
        $requestParams               = $this->formatter($requestParams);
        $requestParams["uuid"]       = UUID::getUUID();
        $requestParams['store_uuid'] = UserInfo::getStoreUserInfo()['store_uuid'];

        return (new ContentRepository)->repositoryCreate($requestParams);
    }

    public function serviceUpdate(array $requestParams): int
    {
        unset($requestParams["creator"]);
        if (!isset($requestParams["uuid"])) return 0;
        $requestParams = $this->formatter($requestParams);
        $uuid          = $requestParams["uuid"];
        unset($requestParams["uuid"]);

        return (new ContentRepository)->repositoryUpdate([
            ['uuid', '=', $uuid],
        ], $requestParams);
    }

    public function serviceDelete(array $requestParams): int
    {
        $uuidArray   = explode(',', $requestParams['uuid']);
        $deleteWhere = [];
        foreach ($uuidArray as $value) {
            $deleteWhere[] = $value;
        }

        return (new ContentRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    public function serviceFind(array $requestParams): array
    {
        return (new ContentRepository)->repositoryFind(self::searchWhere($requestParams));
    }

    private function formatter(array $requestParams): array
    {
        $requestParams["tags"]         = str_replace("，", ",", $requestParams["tags"]);
        $requestParams["title"]        = trim($requestParams["title"]);
        $requestParams["author"]       = trim($requestParams["author"]);
        $requestParams["publish_time"] = date("Y-m-d H:i:s");
        $imageArray                    = [];
        if ($requestParams["content_type"] == 1) {
            $imageArray = ImageSrcSearch::searchImageUrl((string)$requestParams['content']);
        } else if ($requestParams["content_type"]) {
            $imageArray = ImageSrcSearch::searchMarkDownIMageUrl((string)$requestParams["content"]);
        }
        if (!empty($imageArray)) {
            $remoteFileArray          = (new FileUpload())->fileUpload($imageArray);
            $requestParams['content'] = ImageSrcSearch::replaceImageUrl((string)$requestParams['content'], $remoteFileArray, (int)$requestParams["content_type"]);
        }

        return $requestParams;
    }
}