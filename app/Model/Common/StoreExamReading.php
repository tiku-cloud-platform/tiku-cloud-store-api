<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 问答试题
 *
 * Class StoreExamReading
 * @package App\Model\Common
 */
class StoreExamReading extends BaseModel
{
    protected $table = 'store_exam_reading';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'title',
        'content',
        'tips_expend_score',
        'answer_income_score',
        'analysis',
        'level',
        'is_show',
        'source_url',
        'source_author',
        "video_url",
        "is_search",
    ];
}