<?php
declare(strict_types = 1);

namespace App\Repository\Store\Exam;


use App\Model\Store\StoreExamOption;
use App\Repository\StoreRepositoryInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 选择试题
 *
 * Class OptionRepository
 * @package App\Repository\Store\Exam
 */
class OptionRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreExamOption
     */
    protected $optionsModel;

    public function __construct()
    {
    }

    /**
     * 查询数据
     *
     * @param \Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->optionsModel::query()
            ->with(['coverFileInfo:uuid,file_name,file_url'])
            ->where($closure)
            ->select($this->optionsModel->searchFields)
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
            $newModel = $this->optionsModel::query()->create(($insertInfo));
            if (!empty($newModel)) {
                /** @var string $uuid 试题uuid */
                $uuid = $newModel->getAttribute('uuid');
                // 试题选项
                (new OptionItemRepository())->repositoryCreate((array)[
                    'option'      => $insertInfo['option_item'],
                    'option_uuid' => $uuid,
                ]);
                // 试题分类关联
                if (!empty($insertInfo['category'])) {
                    $examCategoryArray = [];
                    $categoryArray     = $insertInfo['category'];
                    foreach ($categoryArray as $key => $value) {
                        $examCategoryArray[$key] = [
                            'exam_category_uuid' => $value,
                            'exam_uuid'          => $uuid,
                            'store_uuid'         => $insertInfo['store_uuid']
                        ];
                    }
                    (new CategoryRelationRepository())->repositoryCreate((array)$examCategoryArray);
                }
                // 知识点关联
                if (!empty($insertInfo['tag'])) {
                    $examTagArray = [];
                    $tagArray     = $insertInfo['tag'];
                    foreach ($tagArray as $key => $value) {
                        $examTagArray[$key] = [
                            'exam_tag_uuid' => $value,
                            'exam_uuid'     => $uuid,
                            'store_uuid'    => $insertInfo['store_uuid']
                        ];
                    }
                    (new TagRelationRepository())->repositoryCreate((array)$examTagArray);
                }
                // 试卷关联
                if (!empty($insertInfo['collection'])) {
                    $examCollectionArray = [];
                    $collectionArray     = $insertInfo['collection'];
                    foreach ($collectionArray as $key => $value) {
                        $examCollectionArray[$key] = [
                            'exam_collection_uuid' => $value,
                            'exam_uuid'            => $uuid,
                            'store_uuid'           => $insertInfo['store_uuid']
                        ];
                    }
                    (new CollectionRelationRepository())->repositoryCreate((array)$examCollectionArray);
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
        $bean = $this->optionsModel::query()
            ->with(['coverFileInfo:uuid,file_name,file_url'])
            ->with(['optionItem:uuid,option_uuid,is_check,check,title'])
            ->where($closure)
            ->first($this->optionsModel->searchFields);

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
            $uuid = $updateWhere[1][2];
            /** @var string $storeId 商户id */
            $storeId = $updateWhere[0][2];
            // 试题选项
            (new OptionItemRepository())->repositoryUpdate((array)$updateWhere, (array)$updateInfo['option_item']);
            // 试题分类关联
            $categoryRelationRepository = new CategoryRelationRepository();
            $categoryRelationRepository->repositoryWhereInDelete((array)[$uuid], (string)'exam_uuid');
            if (!empty($updateInfo['category'])) {
                $examCategoryArray = [];
                $categoryArray     = $updateInfo['category'];
                foreach ($categoryArray as $key => $value) {
                    $examCategoryArray[$key] = [
                        'exam_category_uuid' => $value,
                        'exam_uuid'          => $uuid,
                        'store_uuid'         => $storeId
                    ];
                }
                $categoryRelationRepository->repositoryCreate((array)$examCategoryArray);
            }

            // 知识点关联
            $tagRelationRepository = new TagRelationRepository();
            $tagRelationRepository->repositoryWhereInDelete((array)[$uuid], (string)'exam_uuid');
            if (!empty($updateInfo['tag'])) {
                $examTagArray = [];
                $tagArray     = $updateInfo['tag'];
                foreach ($tagArray as $key => $value) {
                    $examTagArray[$key] = [
                        'exam_tag_uuid' => $value,
                        'exam_uuid'     => $uuid,
                        'store_uuid'    => $storeId
                    ];
                }
                $tagRelationRepository->repositoryCreate((array)$examTagArray);
            }

            // 试卷关联
            $collectionRelationRepository = new CollectionRelationRepository();
            $collectionRelationRepository->repositoryWhereInDelete((array)[$uuid], (string)'exam_uuid');
            if (!empty($updateInfo['collection'])) {
                $examCollectionArray = [];
                $collectionArray     = $updateInfo['collection'];
                foreach ($collectionArray as $key => $value) {
                    $examCollectionArray[$key] = [
                        'exam_collection_uuid' => $value,
                        'exam_uuid'            => $uuid,
                        'store_uuid'           => $storeId
                    ];
                }
                $collectionRelationRepository->repositoryCreate((array)$examCollectionArray);
            }

            unset($updateInfo['collection']);
            unset($updateInfo['tag']);
            unset($updateInfo['category']);
            unset($updateInfo['option_item']);

            $result = $this->optionsModel::query()->where($updateWhere)->update(($updateInfo));
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
        return $this->optionsModel::query()->where($deleteWhere)->delete();
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
            $result = $this->optionsModel::query()->whereIn($field, $deleteWhere)->delete();

            $collectionRelationRepository = new CollectionRelationRepository();
            $collectionRelationRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'exam_uuid');

            $tagRelationRepository = new TagRelationRepository();
            $tagRelationRepository->repositoryWhereInDelete((array)$deleteWhere, (string)'exam_uuid');

            $categoryRelationRepository = new CategoryRelationRepository();
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
        return $this->optionsModel::query()->where($closure)->count();
    }
}