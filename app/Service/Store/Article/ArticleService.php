<?php
declare(strict_types = 1);

namespace App\Service\Store\Article;


use App\Library\File\FileUpload;
use App\Library\File\ImageSrcSearch;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Mapping\WeChatRequest;
use App\Repository\Store\Article\ArticleRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 文章管理
 *
 * Class ArticleService
 * @package App\Service\Store\Article
 */
class ArticleService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var ArticleRepository
     */
    protected $articleRepository;

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
        return $this->articleRepository->repositorySelect(
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
        $imageArray = ImageSrcSearch::searchImageUrl((string)$requestParams['content']);
        if (!empty($imageArray)) {
            $remoteFileArray          = (new FileUpload())->fileUpload((array)$imageArray);
            $requestParams['content'] = ImageSrcSearch::replaceImageUrl((string)$requestParams['content'], (array)$remoteFileArray);
        }

        $requestParams['uuid']       = UUID::getUUID();
        $requestParams['store_uuid'] = UserInfo::getStoreUserInfo()['store_uuid'];

        return $this->articleRepository->repositoryCreate($requestParams);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        $imageArray = ImageSrcSearch::searchImageUrl((string)$requestParams['content']);
        if (!empty($imageArray)) {
            $remoteFileArray          = (new FileUpload())->fileUpload((array)$imageArray);
            $requestParams['content'] = ImageSrcSearch::replaceImageUrl((string)$requestParams['content'], (array)$remoteFileArray);
        }
        return $this->articleRepository->repositoryUpdate((array)[
            ['uuid', '=', trim($requestParams['uuid'])],
        ], (array)[
            'title'                 => trim($requestParams['title']),
            'file_uuid'             => trim($requestParams['file_uuid']),
            'content'               => $requestParams['content'],
            'publish_date'          => trim($requestParams['publish_date']),
            'author'                => trim($requestParams['author']),
            'orders'                => $requestParams['orders'],
            'is_show'               => $requestParams['is_show'],
            'is_top'                => $requestParams['is_top'],
            'source'                => trim($requestParams['source']),
            'article_category_uuid' => trim($requestParams['article_category_uuid']),
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

        return $this->articleRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->articleRepository->repositoryFind(self::searchWhere((array)$requestParams));
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
            array_push($updateWhere, $value);
        }
        $returnInfo = [
            'code' => 0,
            'msg'  => '请求成功',
            'data' => [],
        ];
        // 请求微信收录接口
        $accessToken = (new WeChatRequest())->getMiNIWeChatToken((string)UserInfo::getStoreUserInfo()['store_uuid']);
        if (!empty($accessToken)) {
            if ($this->articleRepository->repositoryWhereInUpdate((array)$updateWhere, (string)'uuid', (array)['is_publish' => 1]) == 0) {
                $returnInfo['code'] = 1;
                $returnInfo['msg']  = '发布失败';
            } else {
                $pages = [];
                foreach ($uuidArray as $value) {
                    array_push($pages, ["path" => "pages/article/detail/detail", 'query' => "uuid=" . $value]);
                }
                $requestResult = (new WeChatRequest())->submitPages((string)$accessToken, (array)["data" => $pages]);
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