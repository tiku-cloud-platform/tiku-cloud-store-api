<?php
declare(strict_types=1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\Relations\HasMany;

/**
 * 选择试题
 *
 * Class StoreExamOption
 * @package App\Model\Common
 */
class StoreExamOption extends BaseModel
{
    protected $table = 'store_exam_option';

    protected $fillable = [
        'uuid',
        'title',
        'file_uuid',
        'answer',
        'analysis',
        'tips_expend_score',
        'answer_income_score',
        'is_show',
        'store_uuid',
        'level',
    ];

    public function getAnalysisAttribute($key): string
    {
        return empty($key) ? '' : $key;
    }

    public function getAnswerAttribute($key)
    {
        return explode(',', $key);
    }

    public function optionItem(): HasMany
    {
        return $this->hasMany(StoreExamOptionItem::class, 'option_uuid', 'uuid');
    }

    public function coverFileInfo(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }
}