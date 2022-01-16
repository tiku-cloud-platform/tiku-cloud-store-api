<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 平台用户
 * Class StorePlatformUser
 * @package App\Model\Shell
 */
class StorePlatformUser extends Model
{
    use SoftDeletes;

    protected $table = "store_platform_user";
}