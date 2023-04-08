<?php
declare(strict_types = 1);

namespace App\Service\Article;


use App\Library\File\FileUpload;
use App\Library\File\ImageSrcSearch;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Mapping\WeChatRequest;
use App\Repository\Article\ArticleRepository;
use App\Service\StoreServiceInterface;

/**
 * 文章管理
 *
 * Class ArticleService
 * @package App\Service\Store\Article
 */
class ArticleService implements StoreServiceInterface
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
            if (!empty($category_uuid)) {
                $query->where('article_category_uuid', '=', $category_uuid);
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
        return (new ArticleRepository)->repositorySelect(
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

        return (new ArticleRepository)->repositoryCreate($requestParams);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     * @throws \Exception
     */
    public function serviceUpdate(array $requestParams): int
    {
        unset($requestParams["creator"]);
        if ($requestParams["content_type"] == 1) {
            $imageArray = ImageSrcSearch::searchImageUrl((string)$requestParams['content']);
            if (!empty($imageArray)) {
                $remoteFileArray          = (new FileUpload())->fileUpload($imageArray);
                $requestParams['content'] = ImageSrcSearch::replaceImageUrl((string)$requestParams['content'], $remoteFileArray);
            }
        }

        return (new ArticleRepository)->repositoryUpdate([
            ['uuid', '=', trim($requestParams['uuid'])],
        ], [
            'title' => trim($requestParams['title']),
            'file_uuid' => trim($requestParams['file_uuid']),
            'content' => $requestParams['content'],
            'content_desc' => $requestParams['content_desc'],
            'publish_date' => trim($requestParams['publish_date']),
            'author' => trim($requestParams['author']),
            'orders' => $requestParams['orders'],
            'is_show' => $requestParams['is_show'],
            'is_top' => $requestParams['is_top'],
            'source' => trim($requestParams['source']),
            'article_category_uuid' => trim($requestParams['article_category_uuid']),
            "read_score" => $requestParams["read_score"],
            "share_score" => $requestParams["share_score"],
            "click_score" => $requestParams["click_score"],
            "collection_score" => $requestParams["collection_score"],
            "read_expend_score" => $requestParams["read_expend_score"],
            "content_type" => $requestParams["content_type"]
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
            $deleteWhere[] = $value;
        }

        return (new ArticleRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return (new ArticleRepository)->repositoryFind(self::searchWhere($requestParams));
    }

    /**
     * 批量提交收录信息
     *
     * @param array $requestParams
     * @return array
     */
    public function servicePublish(array $requestParams): array
    {
        $uuidArray   = explode(',', $requestParams['uuid']);
        $updateWhere = [];
        foreach ($uuidArray as $value) {
            $updateWhere[] = $value;
        }
        $returnInfo = [
            'code' => 0,
            'msg' => '请求成功',
            'data' => [],
        ];
        // 请求微信收录接口
        $accessToken = (new WeChatRequest())->getMiNIWeChatToken((string)UserInfo::getStoreUserInfo()['store_uuid']);
        if (!empty($accessToken)) {
            if ((new ArticleRepository)->repositoryWhereInUpdate($updateWhere, 'uuid', ['is_publish' => 1]) == 0) {
                $returnInfo['code'] = 1;
                $returnInfo['msg']  = '发布失败';
            } else {
                $pages = [];
                foreach ($uuidArray as $value) {
                    $pages[] = ["path" => "pages/article/detail/detail", 'query' => "uuid=" . $value];
                }
                $requestResult = (new WeChatRequest())->submitPages($accessToken, ["data" => $pages]);
                if ($requestResult['code'] != 0) {
                    $returnInfo['code'] = 1;
                    $returnInfo['msg']  = $requestResult['msg'];
                }
            }
        } else {
            $returnInfo['code'] = 1;
            $returnInfo['msg']  = '微信凭据获取失败 请重试!';
        }

        return $returnInfo;
    }
}