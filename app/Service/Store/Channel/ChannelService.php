<?php
declare(strict_types = 1);

namespace App\Service\Store\Channel;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Channel\ChannelRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 渠道统计
 * Class ChannelService
 * @package App\Service\Store\Channel
 */
class ChannelService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var ChannelRepository
     */
    protected $channelModel;

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
            if (!empty($is_show)) {
                $query->where('is_show', '=', $is_show);
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
        return $this->channelModel->repositorySelect(
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

        return $this->channelModel->repositoryCreate($requestParams);
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        return $this->channelModel->repositoryUpdate((array)[
            ['uuid', '=', $requestParams['uuid'] ?? ""],
        ], (array)[
            'title'              => trim($requestParams['title']),
            'is_show'            => $requestParams['is_show'],
            'channel_group_uuid' => $requestParams['channel_group_uuid'],
            'remark'             => $requestParams["remark"],
            'file_uuid'          => $requestParams["file_uuid"],
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

        return $this->channelModel->repositoryWhereInDelete((array)$deleteWhere, (string)'uuid');
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->channelModel->repositoryFind(self::searchWhere((array)$requestParams));
    }
}