<?php
declare(strict_types = 1);

namespace App\Service\Store\Subscribe;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Subscribe\ConfigRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 微信订阅消息配置
 *
 * Class ConfigService
 * @package App\Service\Store\Subscribe
 */
class ConfigService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var ConfigRepository
     */
    protected $configRepository;

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
        return $this->configRepository->repositorySelect(
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

        return $this->configRepository->repositoryCreate($requestParams);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        return $this->configRepository->repositoryUpdate((array)[
            ['uuid', '=', trim($requestParams['uuid'])],
        ], (array)[
            'title'             => trim($requestParams['title']),
            'template_id'       => $requestParams['template_id'],
            'page'              => $requestParams['page'],
            'data'              => json_encode($requestParams['data'], JSON_UNESCAPED_UNICODE),
            'miniprogram_state' => trim($requestParams['miniprogram_state']),
            'lang'              => trim($requestParams['lang']),
            'is_show'           => $requestParams['is_show'],
            'orders'            => $requestParams['orders'],
            'file_uuid'         => trim($requestParams['file_uuid']),
            'description'       => $requestParams['description'],
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

        return $this->configRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->configRepository->repositoryFind(self::searchWhere((array)$requestParams));
    }
}