<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 单选试题选项
 *
 * Class StoreExamOptionItem
 * @package App\Model\Common
 */
class StoreExamOptionItem extends BaseModel
{
    protected $table = 'store_exam_option_item';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'option_uuid',
        'title',
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
}