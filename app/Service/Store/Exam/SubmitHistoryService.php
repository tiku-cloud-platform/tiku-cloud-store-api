<?php

namespace App\Service\Store\Exam;

use App\Repository\Store\Exam\SubmitHistoryRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 答题历史记录
 *
 * class SubmitHistoryService
 * @package App\Service\Store\Exam
 */
class SubmitHistoryService implements StoreServiceInterface
{
    /**
     * @Inject()
     * @var SubmitHistoryRepository
     */
    protected $historyRepository;

    public function __construct()
    {
    }

    /**
     * 格式化查询条件
     *
     * @param array $requestParams 请求参数
     * @return \Closure 组装的查询条件
     */
    public static function searchWhere(array $requestParams): \Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($user_id)) {
                $query->where('user_uuid', '=', $user_id);
            }
            if (!empty($start_time)) {
                $query->where('created_at', '>=', $start_time);
            }
            if (!empty($end_time)) {
                $query->where('created_at', '<=', $end_time);
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
        $items                = $this->historyRepository->repositorySelect(self::searchWhere((array)$requestParams),
            (int)$requestParams['size'] ?? 20);
        $items['total_score'] = $this->historyRepository->repositorySum((array)[
            ['user_uuid', '=', $requestParams['user_id']]
        ], (array)['score'])['score'];

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
        // TODO: Implement serviceCreate() method.
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        // TODO: Implement serviceUpdate() method.
    }

    /**
     * 删除数据
     *
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array
     */
    public function serviceFind(array $requestParams): array
    {
        // TODO: Implement serviceFind() method.
    }

    /**
     * 查询每日新增用户
     *
     * @param array $requestParams
     * @return array
     */
    public function serviceEveryDayRegister(array $requestParams = []): array
    {
        return $this->historyRepository->repositoryEveryDayCount(self::searchWhere((array)$requestParams));
    }

    /**
     * 查询每日总数
     * @param array $requestParams
     * @return array
     */
    public function serviceEveryDayTotal(array $requestParams = []): array
    {
        foreach ($requestParams as $key => $value) {
            $requestParams[$key]['number'] = $this->historyRepository->repositoryEveryDayTotal((string)$value['date']);
        }

        return $requestParams;
    }
}