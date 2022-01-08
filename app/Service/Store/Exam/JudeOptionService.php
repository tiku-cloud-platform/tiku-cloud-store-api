<?php
declare(strict_types=1);

namespace App\Service\Store\Exam;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Exam\JudeOptionRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 判断试题
 * Class JudeOptionService
 * @package App\Service\Store\Exam
 */
class JudeOptionService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var JudeOptionRepository
     */
    protected $judeOptionRepository;

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
        return $this->judeOptionRepository->repositorySelect(self::searchWhere((array)$requestParams),
            (int)$requestParams['size']);
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

        return $this->judeOptionRepository->repositoryCreate((array)$requestParams);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        $this->judeOptionRepository->repositoryUpdate((array)[
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

        return $this->judeOptionRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->judeOptionRepository->repositoryFind(self::searchWhere((array)$requestParams));
    }

}