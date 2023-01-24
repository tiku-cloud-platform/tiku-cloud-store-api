<?php
declare(strict_types = 1);

namespace App\Repository\Exam;

use App\Model\Store\StoreExamJudgeOption;
use App\Repository\StoreRepositoryInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 判断试题
 * Class JudeOptionRepository
 * @package App\Repository\Store\Exam
 */
class JudeOptionRepository implements StoreRepositoryInterface
{
    /**
     * 查询数据
     *
     * @param \Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = (new StoreExamJudgeOption)::query()
            ->with(['coverFileInfo:uuid,file_name,file_url'])
            ->with(['creator:id,name'])
            ->where($closure)
            ->select([
                'uuid',
                'store_uuid',
                'title',
                'answer',
                'level',
                'analysis',
                'file_uuid',
                'tips_expend_score',
                'answer_income_score',
                'is_show',
                'created_at',
                "create_id",
            ])
            ->orderByDesc('id')
            ->paginate($perSize);

        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size' => $items->perPage(),
            'page' => $items->currentPage(),
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
        // 添加判断试题、标签关联、试卷、分类关联
        $result = false;
        Db::transaction(function () use ($insertInfo, &$result) {
            $newModel = (new StoreExamJudgeOption)::query()->create($insertInfo);
            if (!empty($newModel)) {
                $uuid = $newModel->getAttribute('uuid');
                // 试题分类关联
                if (!empty($insertInfo['category'])) {
                    $examCategoryArray = [];
                    $categoryArray     = $insertInfo['category'];
                    foreach ($categoryArray as $key => $value) {
                        $examCategoryArray[$key] = [
                            'category_uuid' => $value,
                            'exam_uuid' => $uuid,
                            'store_uuid' => $insertInfo['store_uuid']
                        ];
                    }
                    (new JudeCategoryRelationRepository())->repositoryCreate((array)$examCategoryArray);
                }
                // 知识点关联
                if (!empty($insertInfo['tag'])) {
                    $examTagArray = [];
                    $tagArray     = $insertInfo['tag'];
                    foreach ($tagArray as $key => $value) {
                        $examTagArray[$key] = [
                            'tag_uuid' => $value,
                            'exam_uuid' => $uuid,
                            'store_uuid' => $insertInfo['store_uuid']
                        ];
                    }
                    (new JudeTagRelationRepository())->repositoryCreate((array)$examTagArray);
                }
                // 试卷关联
                if (!empty($insertInfo['collection'])) {
                    $examCollectionArray = [];
                    $collectionArray     = $insertInfo['collection'];
                    foreach ($collectionArray as $key => $value) {
                        $examCollectionArray[$key] = [
                            'collection_uuid' => $value,
                            'exam_uuid' => $uuid,
                            'store_uuid' => $insertInfo['store_uuid']
                        ];
                    }
                    (new JudeCollectionRelationRepository())->repositoryCreate((array)$examCollectionArray);
                }
            }
        }, 2);

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
        $bean = (new StoreExamJudgeOption)::query()
            ->with(['coverFileInfo:uuid,file_name,file_url'])
            ->with(['optionItem:uuid,option_uuid,is_check,check,title'])
            ->with(['creator:id,name'])
            ->where($closure)
            ->first([
                'uuid',
                'store_uuid',
                'title',
                'answer',
                'level',
                'analysis',
                'file_uuid',
                'tips_expend_score',
                'answer_income_score',
                'is_show',
                'created_at',
                "create_id",
            ]);

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

}