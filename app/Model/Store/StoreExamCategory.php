<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 试题分类
 *
 * Class StoreExamCategory
 * @package App\Model\Store
 */
class StoreExamCategory extends \App\Model\Common\StoreExamCategory
{
    public $searchFields = [
        'uuid',
        'title',
        'parent_uuid',
        'remark',
        'is_show',
        'file_uuid',
        'big_file_uuid',
        'orders',
        'is_recommend',
    ];

    public function children()
    {
        return $this->hasMany(StoreExamCategory::class, 'parent_uuid', 'uuid');
    }

    public function allChildren()
    {
        return $this->hasMany(StoreExamCategory::class, 'parent_uuid', 'uuid')
            ->with(['smallFileInfo:uuid,file_name,file_url'])
            ->where("is_show", "=", 1)
            ->orderByDesc("orders");
    }
}