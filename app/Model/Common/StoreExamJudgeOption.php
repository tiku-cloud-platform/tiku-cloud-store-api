<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 单选试题
 * Class StoreExamJudgeOption
 * @package App\Model\Common
 */
class StoreExamJudgeOption extends BaseModel
{
    protected $table = 'store_exam_judge_option';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'title',
        'answer',
        'level',
        'analysis',
        'file_uuid',
        'tips_expend_score',
        'answer_income_score',
        'is_show',
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

    public function getAnalysisAttribute($key): string
    {
        return empty($key) ? '' : $key;
    }

    public function coverFileInfo(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }
}