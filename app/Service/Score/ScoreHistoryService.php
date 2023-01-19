<?php
declare(strict_types = 1);

namespace App\Service\Score;


use App\Repository\Score\ScoreHistoryRepository;
use App\Service\StoreServiceInterface;

/**
 * 用户积分历史
 * Class ScoreHistoryService
 * @package App\Service\Store\Score
 */
class ScoreHistoryService implements StoreServiceInterface
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
            if (!empty($type)) {
                $query->where('type', '=', $type);
            }
            if (!empty($score_key)) {
                $query->where('score_key', '=', $score_key);
            }
            if (!empty($start_time)) {
                $query->where('created_at', '>=', $start_time);
            }
            if (!empty($end_time)) {
                $query->where('created_at', '<=', $end_time);
            }
            if (!empty($user_id)) {
                $query->where('user_uuid', '=', $user_id);
            }
            if (!empty($client_type)) {
                $query->where('client_type', '=', $client_type);
            }
        };
    }

    /**
     * 查询数据
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        $items = (new ScoreHistoryRepository)->repositorySelect(
            self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20
        );

        // 查询积分汇总
        if (!empty($requestParams['user_id'])) {
            $income = (new ScoreHistoryRepository)->repositorySum([['user_uuid', '=', $requestParams['user_id']], ['type', '=', 1]], ['score']);
            $expend = (new ScoreHistoryRepository)->repositorySum([['user_uuid', '=', $requestParams['user_id']], ['type', '=', 2]], ['score']);
        } else {
            $income = (new ScoreHistoryRepository)->repositorySum([['type', '=', 1]], ['score']);
            $expend = (new ScoreHistoryRepository)->repositorySum([['type', '=', 2]], ['score']);
        }
        $items['income'] = $income['score'] ?? "0.00";
        $items['expend'] = $expend['score'] ?? "0.00";

        return $items;
    }

    /**
     * 创建数据
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        return false;
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