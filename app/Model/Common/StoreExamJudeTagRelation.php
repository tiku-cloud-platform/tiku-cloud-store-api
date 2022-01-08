<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 判断题知识点关联
 * Class StoreExamJudeTagRelation
 * @package App\Model\Common
 */
class StoreExamJudeTagRelation extends BaseModel
{
    protected $table = 'store_exam_jude_tag_relation';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'exam_uuid',
        'tag_uuid',
        'is_show',
    ];
}