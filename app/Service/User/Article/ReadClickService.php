<?php
declare(strict_types = 1);

namespace App\Service\User\Article;


use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\User\Article\ReadClickRepository;
use App\Service\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 文章阅读点赞记录
 *
 * Class ReadClickService
 * @package App\Service\User\Article
 */
class ReadClickService implements UserServiceInterface
{
    /**
     * @Inject()
     * @var ReadClickRepository
     */
    protected $readClickRepository;

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
        // TODO: Implement searchWhere() method.
    }

    /**
     * 查询数据
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    /**
     * 创建数据
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        $userInfo = UserInfo::getWeChatUserInfo();
        if (!empty($userInfo)) {
            $requestParams['uuid']       = UUID::getUUID();
            $requestParams['store_uuid'] = $userInfo['store_uuid'];
            $requestParams['user_uuid']  = $userInfo['user_uuid'];

            return $this->readClickRepository->repositoryCreate((array)$requestParams);
        }

        return false;
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
        // TODO: Implement serviceFind() method.
    }
}