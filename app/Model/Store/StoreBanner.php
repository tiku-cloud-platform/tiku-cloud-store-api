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
    protected $casts = [
        'position_position' => 'string',
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
        return $this->belongsTo(StoreDictionary::class, "position_position", "uuid");
    }
}