<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 问答知识点关联
 *
 * Class StoreExamReadingTagRelation
 * @package App\Model\Store
 */
class StoreExamReadingTagRelation extends \App\Model\Common\StoreExamReadingTagRelation
{
    public $searchFields = [
        'uuid',
        'store_uuid',
        'tag_uuid',
        'is_show',
    ];
}