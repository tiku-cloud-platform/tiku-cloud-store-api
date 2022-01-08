<?php

declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 互动相关图片
 * Class StoreActivityImage
 * @package App\Model\Common
 */
class StoreActivityImage extends BaseModel
{
    protected $table = 'store_activity_image';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'activity_uuid',
        'file_uuid',
        'is_show',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [];

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