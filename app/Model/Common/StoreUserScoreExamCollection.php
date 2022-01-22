<?php
declare(strict_types = 1);

namespace App\Model\Common;

/**
 * 用户答题积分汇总
 * Class StoreUserScoreExamCollection
 * @package App\Model\Common
 */
class StoreUserScoreExamCollection
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