<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 用户积分汇总
 * Class StoreUserScoreCollection
 * @package App\Model\Common
 */
class StoreUserScoreCollection extends Model
{
    use SoftDeletes;

    protected $table = "store_user_score_collection";

    protected $fillable = [
        "uuid",
        "user_uuid",
        "score",
        "created_at",
        "updated_at",
        "store_uuid",
    ];
}