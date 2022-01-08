<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 问答试卷关联
 *
 * Class StoreExamReadingCollectionRelation
 * @package App\Model\Common
 */
class StoreExamReadingCollectionRelation extends BaseModel
{
    protected $table = 'store_exam_reading_collection_relation';

    protected $fillable = [
        'uuid',
        'exam_uuid',
        'store_uuid',
        'collection_uuid',
        'is_show',
    ];
}