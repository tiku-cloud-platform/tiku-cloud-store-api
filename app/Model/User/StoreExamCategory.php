<?php
declare(strict_types = 1);

namespace App\Model\User;

/**
 * 试卷分类
 *
 * Class StoreExamCategory
 * @package App\Model\User
 */
class StoreExamCategory extends \App\Model\Common\StoreExamCategory
{
    public $listSearchFields = [
        'uuid',
        'title',
        'file_uuid',
        'big_file_uuid',
        'parent_uuid',
    ];
}