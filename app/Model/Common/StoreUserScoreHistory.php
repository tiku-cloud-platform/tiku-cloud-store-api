<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 用户积分历史
 *
 * Class StoreUserScoreHistory
 * @package App\Model\Common
 */
class StoreUserScoreHistory extends BaseModel
{
    protected $table = 'store_user_score_history';

    protected $fillable = [
        'uuid',
        'type',
        'title',
        'score',
        'user_uuid',
        'score_key',
        'store_uuid'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(StorePlatformUser::class, 'user_uuid', 'uuid');
    }
}