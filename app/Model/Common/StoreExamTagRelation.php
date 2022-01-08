<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;

/**
 * 试题知识点关联
 *
 * Class StoreExamTagRelation
 * @package App\Model\Common
 */
class StoreExamTagRelation extends BaseModel
{
    protected $table = 'store_exam_tag_relation';

    protected $fillable = [
        'exam_tag_uuid',
        'exam_uuid',
        'store_uuid',
    ];
}