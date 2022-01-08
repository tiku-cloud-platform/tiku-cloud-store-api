<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 问答知识点关联
 *
 * Class StoreExamReadingTagRelation
 * @package App\Model\Common
 */
class StoreExamReadingTagRelation extends BaseModel
{
    protected $table = 'store_exam_reading_tag_relation';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'tag_uuid',
        'is_show',
    ];
}