<?php
declare(strict_types = 1);

namespace App\Service\Store\Score;


use App\Repository\Store\Score\ScoreHistoryRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户积分历史
 *
 * Class ScoreHistoryService
 * @package App\Service\Store\Score
 */
class ScoreHistoryService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var ScoreHistoryRepository
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
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        $items = $this->scoreRepository->repositorySelect(
            self::searchWhere((array)$requestParams),
            (int)$requestParams['size'] ?? 20
        );

        // 查询积分汇总
        $income = $expend = 0;
        if (!empty($requestParams['user_id'])) {
            $income = $this->scoreRepository->repositorySum((array)[['user_uuid', '=', $requestParams['user_id']], ['type', '=', 1]], (array)['score']);
            $expend = $this->scoreRepository->repositorySum((array)[['user_uuid', '=', $requestParams['user_id']], ['type', '=', 2]], (array)['score']);
        }
        $items['income'] = $income['score'];
        $items['expend'] = $expend['score'];

        return $items;
    }

    /**
     * 创建数据
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {

    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {

    }

    /**
     * 删除数据
     *
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams): int
    {

    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {

    }
}