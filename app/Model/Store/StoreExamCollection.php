<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 试卷
 *
 * Class StoreExamCollection
 * @package App\Model\Store
 */
class StoreExamCollection extends \App\Model\Common\StoreExamCollection
{
    public $searchFields = [
        'uuid',
        'title',
        'is_show',
        'file_uuid',
        'orders',
        'is_recommend',
        'submit_number',
        'exam_category_uuid',
        'exam_time',
        'content',
        'level',
        'author',
        'audit_author',
        "max_option_total",
        "max_judge_total",
        "max_reading_total",
    ];
}