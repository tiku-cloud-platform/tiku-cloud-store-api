<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 *  试题提交记录
 *
 * Class StoreExamSubmitHistory
 * @package App\Model\Common
 */
class StoreExamSubmitHistory extends BaseModel
{
    protected $table = 'store_exam_submit_history';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'exam_collection_uuid',
        'exam_uuid',
        'score',
        'submit_time',
        'exam_answer',
        'select_answer',
        'type',
        'is_show',
        'store_uuid',
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(StoreExamCollection::class, 'exam_collection_uuid', 'uuid')
            ->with(['coverFileInfo:uuid,file_url,file_name', 'collectionType:uuid,title']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(StorePlatformUser::class, 'user_uuid', 'uuid');
    }
}