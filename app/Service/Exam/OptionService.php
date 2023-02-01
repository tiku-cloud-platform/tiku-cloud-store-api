<?php
declare(strict_types = 1);

namespace App\Service\Exam;

use App\Mapping\HttpDataResponse;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Exam\CollectionRelationRepository;
use App\Repository\Exam\CollectionRepository;
use App\Repository\Exam\OptionRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 选择试题
 *
 * Class OptionsService
 * @package App\Service\Store\Exam
 */
class OptionService implements StoreServiceInterface
{
    /**
     * @Inject
     * @var HttpDataResponse
     */
    protected $httpResponse;

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
        return (new OptionRepository)->repositorySelect(self::searchWhere($requestParams),
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
        $requestParams['answer']     = implode(',', self::getAnswerFormOption($requestParams));

        return (new OptionRepository)->repositoryCreate($requestParams);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        $requestParams['answer'] = implode(',', self::getAnswerFormOption($requestParams));
        unset($requestParams["creator"]);
        return (new OptionRepository)->repositoryUpdate([
            ['uuid', '=', $requestParams['uuid']],
            ['store_uuid', '=', UserInfo::getStoreUserInfo()['store_uuid']]// 绑定关联使用
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

        return (new OptionRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return (new OptionRepository)->repositoryFind(self::searchWhere($requestParams));
    }

    /**
     * 查询总条数
     *
     * @param array $requestParams
     * @return int
     */
    public function serviceCount(array $requestParams = []): int
    {
        return (new OptionRepository)->repositoryCount(self::searchWhere($requestParams));
    }

    /**
     * 从试题选项中解析答案
     *
     * @param array $requestParams
     * @return array
     */
    private static function getAnswerFormOption(array $requestParams): array
    {
        $optionsArray = $requestParams['option_item'];
        $answerArray  = [];
        foreach ($optionsArray as $value) {
            if (is_string($value)) {
                $value = json_decode($value, true);
            }
            if ($value['is_check'] == 1) {
                array_push($answerArray, $value['check']);
            }
        }

        return $answerArray;
    }

    /**
     * 验证试卷最大选择试题
     * @param array $collectionArray 试卷uuid
     * @param string $uuid 当前试题uuid, 用户更新时验证排除当前uuid的计算
     * @return array 试卷信息
     */
    public function verifyCollectionSum(array $collectionArray, string $uuid = ""): array
    {
        $collectionRelationRepository = new CollectionRelationRepository();
        $collectionRepository         = new CollectionRepository();
        $returnMsg                    = ["uuid" => "", "msg" => ""];
        if (empty($collectionArray)) {
            return $returnMsg;
        }
        foreach ($collectionArray as $value) {
            $examSum = $collectionRelationRepository->repositoryWhereInCount("exam_collection_uuid", [$value]);
            $bean    = $collectionRepository->repositoryFind(function ($query) use ($value) {
                $query->where("uuid", "=", $value);
            });

            if (!empty($bean) && $uuid == "" && $bean["max_option_total"] <= $examSum) {
                $returnMsg["uuid"] = $value;
                $returnMsg["msg"]  = $bean["title"];
                break;
            } elseif (!empty($bean) && $uuid != "" && $bean["max_option_total"] < $examSum - 1) {
                $returnMsg["uuid"] = $value;
                $returnMsg["msg"]  = $bean["title"];
                break;
            }
        }

        return $returnMsg;
    }
}