<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 签到汇总记录
 * Class StoreUserSignCollection
 * @package App\Model\Shell
 */
class StoreUserSignCollection extends Model
{
    use SoftDeletes;

    protected $table = "store_user_sign_collection";

    protected $fillable = [
        "uuid",
        "user_uuid",
        "sign_number",
        "is_show",
        "store_uuid",
    ];
}