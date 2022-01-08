<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 活动奖品信息
 * Class StoreActivityPrize
 * @package App\Model\Common
 */
class StoreActivityPrize extends BaseModel
{
    protected $table = 'store_activity_prize';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'file_uuid',
        'title',
        'title',
        'description',
        'introduction',
        'content',
        'worth',
        'type',
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