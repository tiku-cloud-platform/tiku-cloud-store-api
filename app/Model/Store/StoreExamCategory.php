<?php
declare(strict_types = 1);

namespace App\Model\Store;

use Hyperf\Database\Model\Relations\HasMany;

/**
 * 试题分类
 *
 * Class StoreExamCategory
 * @package App\Model\Store
 */
class StoreExamCategory extends \App\Model\Common\StoreExamCategory
{
    public function children()
    {
        return $this->hasMany(StoreExamCategory::class, 'parent_uuid', 'uuid')->with(['creator:id,name']);
    }

    public function allChildren(): HasMany
    {
        return $this->hasMany(StoreExamCategory::class, 'parent_uuid', 'uuid')
            ->with(['smallFileInfo:uuid,file_name,file_url'])
            ->with(['creator:id,name'])
            ->where("is_show", "=", 1)
            ->orderByDesc("orders");
    }
}