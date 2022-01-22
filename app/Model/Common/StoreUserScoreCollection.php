<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 用户积分汇总
 * Class StoreUserScoreCollection
 * @package App\Model\Common
 */
class StoreUserScoreCollection extends BaseModel
{
    protected $fillable = [
        "uuid",
        "user_uuid",
        "score",
        "created_at",
        "updated_at",
        "store_uuid",
    ];
}