<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 判断分类关联
 * Class StoreExamJudeCategoryRelation
 * @package App\Model\Common
 */
class StoreExamJudeCategoryRelation extends BaseModel
{
    protected $table = 'store_exam_jude_category_relation';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'exam_uuid',
        'category_uuid',
        'is_show',
    ];
}