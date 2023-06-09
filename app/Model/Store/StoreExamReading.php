<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 问答试题
 *
 * Class StoreExamReading
 * @package App\Model\Store
 */
class StoreExamReading extends \App\Model\Common\StoreExamReading
{
    protected $appends = [
        'category',
        'tag',
        'collection',
    ];

    public function getCategoryAttribute()
    {
        $categoryItems = StoreExamReadingCategoryRelation::query()->where([
            ['exam_uuid', '=', $this->attributes['uuid']]
        ])->get(['category_uuid']);

        if (!empty($categoryItems)) {
            return array_column($categoryItems->toArray(), 'category_uuid');
        }

        return [];
    }

    public function getTagAttribute()
    {
        $tagItems = StoreExamReadingTagRelation::query()->where([
            ['exam_uuid', '=', $this->attributes['uuid']]
        ])->get(['tag_uuid']);

        if (!empty($tagItems)) {
            return array_column($tagItems->toArray(), 'tag_uuid');
        }

        return [];
    }

    public function getCollectionAttribute()
    {
        $collectionItems = StoreExamReadingCollectionRelation::query()->where([
            ['exam_uuid', '=', $this->attributes['uuid']]
        ])->get(['collection_uuid']);

        if (!empty($collectionItems)) {
            return array_column($collectionItems->toArray(), 'collection_uuid');
        }

        return [];
    }

    public function getSourceUrlAttribute($key)
    {
        return empty($key) ? '' : $key;
    }
}