<?php
declare(strict_types = 1);

namespace App\Model\Store;

use Hyperf\Database\Model\Relations\HasMany;

/**
 * 试题知识点
 *
 * Class StoreExamTag
 * @package App\Model\Store
 */
class StoreExamTag extends \App\Model\Common\StoreExamTag
{
    public $searchFields = [
        'uuid',
        'title',
        'parent_uuid',
        'remark',
        'is_show',
        'orders',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(StoreExamTag::class,'parent_uuid','uuid');
    }
}