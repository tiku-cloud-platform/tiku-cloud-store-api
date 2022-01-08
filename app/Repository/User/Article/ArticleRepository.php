<?php
declare(strict_types = 1);

namespace App\Repository\User\Article;


use App\Model\User\StoreArticle;
use App\Repository\UserRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 文章
 *
 * Class ArticleRepository
 * @package App\Repository\User\Article
 */
class ArticleRepository implements UserRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreArticle
     */
    protected $articleModel;

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
        $items = $this->articleModel::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->where([['is_show', '=', 1]])
            ->where($closure)
            ->select($this->articleModel->listSearchFields)
            ->orderByDesc('orders')
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
        $bean = $this->articleModel::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
            ->where($closure)
            ->where([['is_show', '=', 1]])
            ->select($this->articleModel->searchFields)
            ->first();

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
     * 更新阅读数量
     *
     * @param string $uuid
     * @param string $storeUUID
     * @return int
     */
    public function repositoryUpdateReadNumber(string $uuid): int
    {
        return $this->articleModel->fieldIncr((string)$this->articleModel->getTable(),
            (array)[['uuid', '=', $uuid]],
            (string)'read_number', (int)1);
    }

    /**
     * 更新点赞数量
     *
     * @param string $uuid
     * @param string $storeUUID
     * @return int
     */
    public function repositoryUpdateClickNumber(string $uuid): int
    {
        return $this->articleModel->fieldIncr((string)$this->articleModel->getTable(),
            (array)[['uuid', '=', $uuid]],
            (string)'click_number', (int)1);
    }
}