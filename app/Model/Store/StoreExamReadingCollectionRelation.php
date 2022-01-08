<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 问答试卷关联
 *
 * Class StoreExamReadingCollectionRelation
 * @package App\Model\Store
 */
class StoreExamReadingCollectionRelation extends \App\Model\Common\StoreExamReadingCollectionRelation
{
    public $searchFields = [
        'uuid',
        'exam_uuid',
        'store_uuid',
        'collection_uuid',
        'is_show',
    ];
}