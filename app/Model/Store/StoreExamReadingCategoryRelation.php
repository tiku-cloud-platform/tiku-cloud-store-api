<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 问答分类关联
 *
 * Class StoreExamReadingCategoryRelation
 * @package App\Model\Store
 */
class StoreExamReadingCategoryRelation extends \App\Model\Common\StoreExamReadingCategoryRelation
{
    public $searchFields = [
        'uuid',
        'store_uuid',
        'exam_uuid',
        'category_uuid',
        'is_show',
    ];
}