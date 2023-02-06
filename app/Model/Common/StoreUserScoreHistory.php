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

    public function user(): BelongsTo
    {
        return $this->belongsTo(StorePlatformUser::class, 'user_uuid', 'uuid');
    }
}