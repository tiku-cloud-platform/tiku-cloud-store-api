<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 积分历史记录
 * Class StoreUserScoreHistory
 * @package App\Model\Shell
 */
class StoreUserScoreHistory extends Model
{
    use SoftDeletes;

    protected $table = "store_user_score_history";

    protected $fillable = [
        'uuid',
        'type',
        'title',
        'score',
        'user_uuid',
        'score_key',
        'store_uuid',
        "is_show",
        "client_type"
    ];
}