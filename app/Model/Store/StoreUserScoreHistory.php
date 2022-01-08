<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 用户积分历史
 *
 * Class StoreUserScoreHistory
 * @package App\Model\Store
 */
class StoreUserScoreHistory extends \App\Model\Common\StoreUserScoreHistory
{
    public $searchFileds = [
        'uuid',
        'type',
        'title',
        'score',
        'user_uuid',
        'score_key',
        'created_at',
        'client_type',
    ];

    public function keyInfo()
    {
        return $this->belongsTo(StorePlatformConstConfig::class, 'score_key', 'value')
            ->where('title', '=', 'system_score');
    }
}