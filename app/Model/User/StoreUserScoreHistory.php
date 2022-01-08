<?php
declare(strict_types = 1);

namespace App\Model\User;


/**
 * 用户积分历史
 *
 * Class StoreUserScoreHistory
 * @package App\Model\User
 */
class StoreUserScoreHistory extends \App\Model\Common\StoreUserScoreHistory
{
    public $searchFields = [
        'title',
        'type',
        'score',
        'created_at',
    ];

    public function getCreatedAtAttribute($key)
    {
        return date('Y-m-d', strtotime($key));
    }
}