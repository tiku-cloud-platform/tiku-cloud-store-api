<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 微信小程序
 *
 * Class StoreMiNiWeChatUser
 * @package App\Model\Common
 */
class StoreMiNiWeChatUser extends Model
{
    use SoftDeletes;

    protected $table = 'store_mini_wechat_user';
}