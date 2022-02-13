<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 注册渠道
 * Class StoreChannel
 * @package App\Model\Shell
 */
class StoreChannel extends Model
{
    use SoftDeletes;

    protected $table = "store_channel";
}