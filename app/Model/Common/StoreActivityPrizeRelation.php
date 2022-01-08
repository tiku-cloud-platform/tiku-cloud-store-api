<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 活动奖品关联关系
 * Class StoreActivityPrizeRelation
 * @package App\Model\Common
 */
class StoreActivityPrizeRelation extends BaseModel
{
    protected $table = 'store_activity_prize_relation';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'activity_uuid',
        'prize_uuid',
        'stock',
        'orders',
        'is_show',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * 图片信息
     *
     * @return BelongsTo
     * @author kert
     */
    public function coverFileInfo()
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }
}