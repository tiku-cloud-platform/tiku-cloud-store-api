<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 判断试题
 * Class StoreExamJudgeOption
 * @package App\Model\Store
 */
class StoreExamJudgeOption extends \App\Model\Common\StoreExamJudgeOption
{
    protected $appends = [
        'category',
        'tag',
        'collection',
    ];

    public function getCategoryAttribute()
    {
        $categoryItems = StoreExamCategoryRelation::query()->where([
            ['exam_uuid', '=', $this->attributes['uuid']]
        ])->get(['exam_category_uuid']);

        if (!empty($categoryItems)) {
            return array_column($categoryItems->toArray(), 'exam_category_uuid');
        }

        return [];
    }

    public function getTagAttribute()
    {
        $tagItems = StoreExamTagRelation::query()->where([
            ['exam_uuid', '=', $this->attributes['uuid']]
        ])->get(['exam_tag_uuid']);

        if (!empty($tagItems)) {
            return array_column($tagItems->toArray(), 'exam_tag_uuid');
        }

        return [];
    }

    public function getCollectionAttribute()
    {
        $collectionItems = StoreExamCollectionRelation::query()->where([
            ['exam_uuid', '=', $this->attributes['uuid']]
        ])->get(['exam_collection_uuid']);

        if (!empty($collectionItems)) {
            return array_column($collectionItems->toArray(), 'exam_collection_uuid');
        }

        return [];
    }
}