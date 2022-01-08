<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 判断试卷关联
 * Class StoreExamJudeCollectionRelation
 * @package App\Model\Common
 */
class StoreExamJudeCollectionRelation extends BaseModel
{
    protected $table = 'store_exam_jude_collection_relation';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'exam_uuid',
        'collection_uuid',
        'is_show',
    ];
}