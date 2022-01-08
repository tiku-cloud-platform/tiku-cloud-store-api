<?php
declare(strict_types = 1);

namespace App\Service\Store\Score;


use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Score\ScoreSettingRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台积分配置
 *
 * Class ScoreSettingService
 * @package App\Service\Store\Score
 */
class ScoreSettingService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var ScoreSettingRepository
     */
    protected $scoreRepository;

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
            if (!empty($key)) {
                $query->where('key', '=', $key);
            }
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
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
        return $this->scoreRepository->repositorySelect(
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
        $requestParams['uuid']       = UUID::getUUID();
        $requestParams['store_uuid'] = UserInfo::getStoreUserInfo()['store_uuid'];

        return $this->scoreRepository->repositoryCreate($requestParams);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        return $this->scoreRepository->repositoryUpdate((array)[
            ['uuid', '=', trim($requestParams['uuid'])],
        ], (array)[
            'title'   => trim($requestParams['title']),
            'key'     => trim($requestParams['key']),
            'score'   => trim($requestParams['score']),
            'is_show' => trim($requestParams['is_show']),
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

        return $this->scoreRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->scoreRepository->repositoryFind(self::searchWhere((array)$requestParams));
    }
}