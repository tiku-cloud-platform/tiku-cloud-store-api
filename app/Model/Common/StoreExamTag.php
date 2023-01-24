<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

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
        "create_id",
    ];

    protected $hidden = ["create_id"];

    /**
     * 创建人信息
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(StoreUser::class, "create_id", "id");
    }

    public function setParentUuidAttribute($value)
    {
        $this->attributes['parent_uuid'] = empty($value) ? null : $value;
    }
}