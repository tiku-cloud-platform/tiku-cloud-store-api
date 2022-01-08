<?php
declare(strict_types=1);

namespace App\Model\Common;


use App\Model\BaseModel;

/**
 * 试题知识点
 *
 * Class StoreExamTag
 * @package App\Model\Common
 */
class StoreExamTag extends BaseModel
{
    protected $table = 'store_exam_tag';

    protected $fillable = [
        'uuid',
        'title',
        'parent_uuid',
        'remark',
        'is_show',
        'orders',
        'store_uuid',
    ];

    public function setParentUuidAttribute($value)
    {
        $this->attributes['parent_uuid'] = empty($value) ? null : $value;
    }
}