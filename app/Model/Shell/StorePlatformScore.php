<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 平台积分配置
 *
 * Class StorePlatformScore
 * @package App\Model\Common
 */
class StorePlatformScore extends Model
{
    use SoftDeletes;

    protected $table = 'store_platform_score';

    protected $fillable = [
        'uuid',
        'key',
        'title',
        'score',
        'is_show',
        'store_uuid',
    ];

    /**
     * 查询积分配置信息
     * @param array $searchWhere
     * @return array
     */
    public function getScoreConfig(array $searchWhere): array
    {
        $bean = self::query()->where($searchWhere)->first(["uuid", "score", "key", "title"]);
        if (!empty($bean)) return $bean->toArray();
        return [];
    }
}