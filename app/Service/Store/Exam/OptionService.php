<?php
declare(strict_types = 1);

namespace App\Service\Store\Exam;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Exam\OptionRepository;
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
     * @Inject()
     * @var OptionRepository
     */
    protected $optionRepository;

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
        return $this->optionRepository->repositorySelect(self::searchWhere((array)$requestParams),
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
        $requestParams['answer']     = implode(',', self::getAnswerFormOption((array)$requestParams));

        return $this->optionRepository->repositoryCreate((array)$requestParams);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        $requestParams['answer'] = implode(',', self::getAnswerFormOption((array)$requestParams));

        return $this->optionRepository->repositoryUpdate((array)[
            ['uuid', '=', $requestParams['uuid']],
            ['store_uuid', '=', UserInfo::getStoreUserInfo()['store_uuid']]// 绑定关联使用
        ], (array)$requestParams);
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

        return $this->optionRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->optionRepository->repositoryFind(self::searchWhere((array)$requestParams));
    }

    /**
     * 查询总条数
     *
     * @param array $requestParams
     * @return int
     */
    public function serviceCount(array $requestParams = []): int
    {
        return $this->optionRepository->repositoryCount(self::searchWhere((array)$requestParams));
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
}