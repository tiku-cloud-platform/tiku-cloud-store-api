<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 用户分组
 *
 * Class StoreWeChatUserGroup
 * @package App\Model\Common
 */
class StorePlatformUserGroup extends Model
{
    use SoftDeletes;

    protected $table = 'store_platform_user_group';

    protected $fillable = [
        'title',
        'store_uuid',
        'uuid',
        'is_show',
    ];

    public function getGroup(array $searchWhere): array
    {
        array_push($searchWhere, ["is_default", "=", 1], ["is_show", "=", 1]);
        $bean = self::query()->where($searchWhere)->first(["uuid"]);
        if (!empty($bean)) {
            return $bean->toArray();
        }
        return [];
    }
}