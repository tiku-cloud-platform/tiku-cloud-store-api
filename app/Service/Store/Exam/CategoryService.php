<?php
declare(strict_types = 1);

namespace App\Service\Store\Exam;


use App\Mapping\RedisClient;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Exam\CategoryRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 试题分类
 *
 * Class CategoryService
 * @package App\Service\Store\Exam
 */
class CategoryService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var CategoryRepository
     */
    protected $categoryRepository;

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
            if (!empty($is_recommend)) {
                $query->where('is_recommend', '=', $is_recommend);
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
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        return $this->categoryRepository->repositorySelect(self::searchWhere((array)$requestParams),
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
        return $this->categoryRepository->repositoryParentSelect(self::searchWhere((array)$requestParams),
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

        $insertResult = $this->categoryRepository->repositoryCreate((array)$requestParams);
        $this->updateApi();

        return $insertResult;
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        $requestParams['parent_uuid'] = empty($requestParams['parent_uuid']) ? null : $requestParams['parent_uuid'];
        $updateRows                   = $this->categoryRepository->repositoryUpdate((array)[
            ['uuid', '=', $requestParams['uuid']]
        ], (array)$requestParams);

        $this->updateApi();
        return $updateRows;
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
        $this->updateApi();
        return $this->categoryRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->categoryRepository->repositoryFind(self::searchWhere((array)$requestParams));
    }

    /**
     * 查询二级类型
     *
     * @param array $requestParams
     * @return array
     */
    public function serviceSecond(array $requestParams): array
    {
        return $this->categoryRepository->repositorySecond(self::searchWhere((array)$requestParams),
            (int)$requestParams['size'] ?? 20);
    }

    /**
     * 更新api端的分类缓存
     * @return bool
     */
    private function updateApi(): bool
    {
        return true;
        $items          = $this->categoryRepository->repositoryAllSelect((array)[["is_show", "=", 1]], (int)1000);
        $items['items'] = $this->recursionData((array)$items['items']);
        $userInfo       = UserInfo::getStoreUserInfo();

        return RedisClient::create((string)"exam_category:", (string)$userInfo['store_uuid'], (array)$items);
    }

    /**
     * 格式化数据[因api端调整，需要重新实现]
     * @param array $info
     * @return array
     */
    private function recursionData(array $info): array
    {
        $tree = [];
        $info = json_decode(json_encode($info), true);// 序列化一次，否则使用对象调用的方式循环，会重复查询数据库一次。

        foreach ($info as $value) {
            $children = [];
            if (!empty($value["all_children"])) {
                foreach ($value["all_children"] as $v) {
                    $children[] = [
                        "title" => $v["title"],
                        "image" => (empty($v["small_file_info"]["file_url"]) ? "" : $v["small_file_info"]["file_url"]) .
                            (empty($v["small_file_info"]["file_name"]) ? "" : $v["small_file_info"]["file_name"]),
                        "uuid"  => $v["uuid"],
                    ];
                }
            }
            $tree[] = [
                "title"    => $value["title"],
                "uuid"     => $value["uuid"],
                "children" => $children
            ];
        }

        return $tree;
    }
}