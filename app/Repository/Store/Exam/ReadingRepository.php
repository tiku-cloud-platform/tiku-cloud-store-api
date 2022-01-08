<?php
declare(strict_types = 1);

namespace App\Repository\Store\Exam;

use App\Model\Store\StoreExamReading;
use App\Repository\StoreRepositoryInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 问答试题
 *
 * Class ExamReadingRepository
 * @package App\Repository\Store\Exam
 */
class ReadingRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreExamReading
     */
    protected $examModel;

    /**
     * 查询数据
     *
     * @param \Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->examModel::query()
            ->where($closure)
            ->select($this->examModel->searchFields)
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
     * 创建数据.
     *
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        // TODO 多线程实现
        // 处理试题与试卷、试题分类、试题知识点
        $result = false;
        Db::transaction(function () use ($insertInfo, &$result) {
            $newModel = $this->examModel::query()->create(($insertInfo));
            if (!empty($newModel)) {
                /** @var string $uuid 试题uuid */
                $uuid = $newModel->getAttribute('uuid');
                // 试题分类关联
                if (!empty($insertInfo['category'])) {
                    $examCategoryArray = [];
                    $categoryArray     = $insertInfo['category'];
                    foreach ($categoryArray as $key => $value) {
                        $examCategoryArray[$key] = [
                            'category_uuid' => $value,
                            'exam_uuid'     => $uuid,
                            'store_uuid'    => $insertInfo['store_uuid']
                        ];
                    }
                    (new ReadingCategoryRelationRepository())->repositoryCreate((array)$examCategoryArray);
                }
                // 知识点关联
                if (!empty($insertInfo['tag'])) {
                    $examTagArray = [];
                    $tagArray     = $insertInfo['tag'];
                    foreach ($tagArray as $key => $value) {
                        $examTagArray[$key] = [
                            'tag_uuid'   => $value,
                            'exam_uuid'  => $uuid,
                            'store_uuid' => $insertInfo['store_uuid']
                        ];
                    }
                    (new ReadingTagRelationRepository())->repositoryCreate((array)$examTagArray);
                }
                // 试卷关联
                if (!empty($insertInfo['collection'])) {
                    $examCollectionArray = [];
                    $collectionArray     = $insertInfo['collection'];
                    foreach ($collectionArray as $key => $value) {
                        $examCollectionArray[$key] = [
                            'collection_uuid' => $value,
                            'exam_uuid'       => $uuid,
                            'store_uuid'      => $insertInfo['store_uuid']
                        ];
                    }
                    (new ReadingCollectionRelationRepository())->repositoryCreate((array)$examCollectionArray);
                }
            }

            $result = true;
        });

        return $result;
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
     * 查询数据
     *
     * @param \Closure $closure
     * @return array
     * @author kert
     */
    public function repositoryFind(\Closure $closure): array
    {
        $bean = $this->examModel::query()
            ->where($closure)
            ->first($this->examModel->searchFields);

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
        // TODO 多线程实现
        // 处理试题与试卷、试题分类、试题知识点
        $result = 0;
        Db::transaction(function () use ($updateInfo, &$result, $updateWhere) {

            /** @var string $uuid 试题uuid */
            $uuid = $updateWhere[0][2];
            /** @var string $storeId 商户id */
            $storeId = $updateWhere[1][2];

            // 试题分类关联
            $categoryRelationRepository = new ReadingCategoryRelationRepository();
            $categoryRelationRepository->repositoryUpdate((array)['exam_uuid' => $uuid, 'store_uuid' => $storeId], (array)$updateInfo['category']);
            // 试题知识点关联
            $tagRelationRepository = new ReadingTagRelationRepository();
            $tagRelationRepository->repositoryUpdate((array)['exam_uuid' => $uuid, 'store_uuid' => $storeId], (array)$updateInfo['tag']);
            // 试题试卷关联
            $collectionRepostory = new ReadingCollectionRelationRepository();
            $collectionRepostory->repositoryUpdate((array)['exam_uuid' => $uuid, 'store_uuid' => $storeId], (array)$updateInfo['collection']);

            unset($updateInfo['collection']);
            unset($updateInfo['tag']);
            unset($updateInfo['category']);

            $result = $this->examModel::query()->where($updateWhere)->update(($updateInfo));
        });

        return $result;
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return $this->examModel::query()->where($deleteWhere)->delete();
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
        // TODO 多线程实现
        // 删除试卷管理、分类关联、知识点关联
        $result = 0;
        Db::transaction(function () use ($deleteWhere, $field, &$result) {
            $result = $this->examModel::query()->whereIn($field, $deleteWhere)->delete();

            $collectionRelationRepository = new ReadingCollectionRelationRepository();
            $collectionRelationRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'exam_uuid');

            $tagRelationRepository = new ReadingTagRelationRepository();
            $tagRelationRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'exam_uuid');

            $categoryRelationRepository = new ReadingCategoryRelationRepository();
            $categoryRelationRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'exam_uuid');
        });

        return $result;
    }

    /**
     * 查询总数据
     *
     * @param \Closure $closure
     * @return int
     */
    public function repositoryCount(\Closure $closure): int
    {
        return $this->examModel::query()->where($closure)->count();
    }
}