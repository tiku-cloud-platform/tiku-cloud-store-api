<?php
declare(strict_types = 1);

namespace App\Service\Notice;

use App\Repository\Notice\NoticeRepository;
use App\Service\StoreServiceInterface;

/**
 * 商户公告
 * Class NoticeService
 * @package App\Service\Store\Notice
 */
class NoticeService implements StoreServiceInterface
{
    /**
     * 格式化查询条件
     * @param array $requestParams 请求参数
     * @return mixed 组装的查询条件
     */
    public static function searchWhere(array $requestParams)
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            $currentDateTime = date('Y-m-d H:i:s');
            $query->where('start_time', '<=', $currentDateTime);
            $query->where('end_time', '>=', $currentDateTime);
        };
    }

    /**
     * 查询数据
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        return (new NoticeRepository)->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
    }

    /**
     * 创建数据
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        return true;
    }

    /**
     * 更新数据
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        return 1;
    }

    /**
     * 删除数据
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams): int
    {
        return 1;
    }

    /**
     * 查询单条数据
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return [];
    }
}