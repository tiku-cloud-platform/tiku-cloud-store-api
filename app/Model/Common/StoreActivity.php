<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 活动基础信息
 * Class StoreActivity
 * @package App\Model\Common
 */
class StoreActivity extends BaseModel
{
    protected $table = 'store_activity';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'title',
        'description',
        'content',
        'sponsor',
        'start_time',
        'end_time',
        'time_text',
        'file_uuid',
        'is_show',
        'is_top',
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