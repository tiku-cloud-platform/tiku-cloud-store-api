<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 签到历史记录
 * Class StoreUserSignHistory
 * @package App\Model\Shell
 */
class StoreUserSignHistory extends Model
{
    use SoftDeletes;

    protected $table = "store_user_sign_history";

    protected $fillable = [
        "uuid",
        "user_uuid",
        "sign_date",
        "is_show",
        "store_uuid",
    ];
}