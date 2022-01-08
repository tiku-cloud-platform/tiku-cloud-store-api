<?php

namespace App\Model\Store;

/**
 * 答题历史记录
 *
 * class StoreExamSubmitHistory
 * @package App\Model\Store
 */
class StoreExamSubmitHistory extends \App\Model\Common\StoreExamSubmitHistory
{
    public $listSearchFields = [
        'uuid',
        'user_uuid',
        'exam_collection_uuid',
        'exam_uuid',
        'score',
        'submit_time',
        'exam_answer',
        'select_answer',
        'type',
    ];
}