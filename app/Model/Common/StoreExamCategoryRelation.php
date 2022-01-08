<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;

/**
 * 试题分类关联
 *
 * Class StoreExamCategoryRelation
 * @package App\Model\Common
 */
class StoreExamCategoryRelation extends BaseModel
{
    protected $table = 'store_exam_category_relation';

    protected $fillable = [
        'exam_category_uuid',
        'exam_uuid',
        'store_uuid',
    ];
}