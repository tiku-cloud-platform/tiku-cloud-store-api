<?php
declare(strict_types = 1);

namespace App\Model\Store;


use App\Constants\DataConfig;
use Hyperf\Database\Model\Relations\BelongsTo;
use function PHPStan\dumpType;

/**
 * 平台轮播图
 *
 * Class StoreBanner
 * @package App\Model\Store
 */
class StoreBanner extends \App\Model\Common\StoreBanner
{
    public $searchFields = [
        'uuid',
        'title',
        'file_uuid',
        'orders',
        'url',
        'position',
        'is_show',
        'type',
        'client_position',
    ];

    protected $casts = [
        'position' => 'string',
        'client_position' => 'string'
    ];

    /**
     * 客户端端口
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(StoreDictionary::class, "client_position", "uuid");
    }

    /**
     * 显示位置
     * @return BelongsTo
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(StoreDictionary::class, "position", "uuid");
    }
}