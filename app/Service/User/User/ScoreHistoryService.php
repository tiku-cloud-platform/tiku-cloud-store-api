<?php
declare(strict_types = 1);

namespace App\Service\User\User;


use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Mapping\WeChatClient;
use App\Repository\User\User\ScoreHistoryRepository;
use App\Service\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 积分历史
 *
 * Class ScoreHistoryService
 * @package App\Service\User\User
 */
class ScoreHistoryService implements UserServiceInterface
{
    /**
     * @Inject()
     * @var ScoreHistoryRepository
     */
    protected $scoreHistoryRepository;

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
            if (!empty($user_uuid)) {
                $query->where('user_uuid', '=', $user_uuid);
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
        $requestParams['user_uuid'] = UserInfo::getWeChatUserInfo()['user_uuid'];

        return $this->scoreHistoryRepository->repositorySelect(self::searchWhere((array)$requestParams),
            (int)$requestParams['size'] ?? 20);
    }

    /**
     * 创建数据
     *
     * @param array $requestParams 请求参数 ['scene' => '积分配置key'， 'data' => ['wechat_user_uuid' => '用户id', 'type' => '积分类型1增加,2减少']]
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        // 查询积分配置场景
        $scoreConfig = (new ScoreConfigService())->serviceFind((array)['key' => $requestParams['scene']]);

        if (!empty($scoreConfig)) {
            $requestParams['data']['title']      = $scoreConfig['title'];
            $requestParams['data']['score_key']  = $scoreConfig['key'];
            $requestParams['data']['score']      = $scoreConfig['score'];
            $requestParams['data']['uuid']       = UUID::getUUID();
            $requestParams['data']['store_uuid'] = (new WeChatClient())->getUUIDHeader();

            return $this->scoreHistoryRepository->repositoryCreate((array)$requestParams['data']);
        }

        return true;
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
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->scoreHistoryRepository->repositoryFind(self::searchWhere((array)$requestParams));
    }

    /**
     * 查询当前用户积分
     *
     * @param string $userId 用户id
     * @return string
     */
    public function scoreCount(string $userId): string
    {
        /** @var array $incomeScore 总收入积分 */
        $incomeScore = $this->scoreHistoryRepository->repositorySum((array)[['type', '=', 1], ['user_uuid', '=', $userId]], (array)['score']);
        /** @var array $expendScore 总支出积分 */
        $expendScore = $this->scoreHistoryRepository->repositorySum((array)[['type', '=', 2], ['user_uuid', '=', $userId]], (array)['score']);

        return sprintf('%01.2f', $incomeScore['score'] - $expendScore['score']);
    }
}