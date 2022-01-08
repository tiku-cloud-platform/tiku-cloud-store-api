<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 问答分类关联
 *
 * Class StoreExamReadingCategoryRelation
 * @package App\Model\Common
 */
class StoreExamReadingCategoryRelation extends BaseModel
{
    protected $table = 'store_exam_reading_category_relation';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'exam_uuid',
        'category_uuid',
        'is_show',
    ];
}