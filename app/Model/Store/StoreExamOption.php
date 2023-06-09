<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 选择试题
 *
 * Class StoreExamOption
 * @package App\Model\Store
 */
class StoreExamOption extends \App\Model\Common\StoreExamOption
{
    protected $appends = [
        'category',
        'tag',
        'collection',
    ];

    public function getCategoryAttribute(): array
    {
        $categoryItems = StoreExamCategoryRelation::query()->where([
            ['exam_uuid', '=', $this->attributes['uuid']]
        ])->get(['exam_category_uuid']);

        if (!empty($categoryItems)) {
            return array_column($categoryItems->toArray(), 'exam_category_uuid');
        }

        return [];
    }

    public function getTagAttribute(): array
    {
        $tagItems = StoreExamTagRelation::query()->where([
            ['exam_uuid', '=', $this->attributes['uuid']]
        ])->get(['exam_tag_uuid']);

        if (!empty($tagItems)) {
            return array_column($tagItems->toArray(), 'exam_tag_uuid');
        }

        return [];
    }

    public function getCollectionAttribute(): array
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