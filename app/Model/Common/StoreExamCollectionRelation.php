<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;

/**
 * 试题试卷关联关系
 *
 * Class StoreExamCollectionRelation
 * @package App\Model\Common
 */
class StoreExamCollectionRelation extends BaseModel
{
    protected $table = 'store_exam_collection_relation';

    protected $fillable = [
        'exam_collection_uuid',
        'exam_uuid',
        'store_uuid',
    ];
}