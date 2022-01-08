<?php
declare(strict_types = 1);

namespace App\Repository\User\User;


use App\Model\User\StorePlatformMessageContent;
use App\Repository\UserRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台文章
 *
 * Class MessageContentRepository
 * @package App\Repository\User\User
 */
class MessageContentRepository implements UserRepositoryInterface
{

    /**
     * @Inject()
     * @var StorePlatformMessageContent
     */
    protected $contentModel;

    public function __construct()
    {
    }

    /**
     * 查询数据
     *
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->contentModel::query()
            ->with(['category:uuid,title'])
            ->where($closure)
            ->select($this->contentModel->listSearchFields)
            ->orderByDesc('id')
            ->paginate((int)$perSize);

        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size'  => $items->perPage(),
            'page'  => $items->currentPage(),
        ];
    }

    /**
     * 创建数据
     *
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        // TODO: Implement repositoryCreate() method.
    }

    /**
     * 添加数据
     *
     * @param array $addInfo 添加信息
     * @return int 添加之后的ID或者行数
     */
    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    /**
     * 单条数据查询
     */
    public function repositoryFind(\Closure $closure): array
    {
        $bean = $this->contentModel::query()
            ->with(['category:uuid,title'])
            ->where([['is_show', '=', 1]])
            ->where($closure)
            ->first($this->contentModel->searchFields);

        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    /**
     * 更新数据
     *
     * @param array $updateWhere 修改条件
     * @param array $updateInfo 修改信息
     * @return int 更新行数
     */
    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        // TODO: Implement repositoryUpdate() method.
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        // TODO: Implement repositoryDelete() method.
    }

    /**
     * 范围删除
     *
     * @param array $deleteWhere 删除条件
     * @param string $field 删除字段
     * @return int
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        // TODO: Implement repositoryWhereInDelete() method.
    }

    /**
     * 查询总数
     *
     * @param array $searchWhere
     * @return int
     */
    public function repositoryCount(array $searchWhere = []): int
    {
        return $this->contentModel::query()->where($searchWhere)->count('id');
    }
}