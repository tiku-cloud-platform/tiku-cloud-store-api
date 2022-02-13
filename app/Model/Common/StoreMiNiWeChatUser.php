<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\HasOne;

/**
 * 微信小程序
 *
 * Class StoreMiNiWeChatUser
 * @package App\Model\Common
 */
class StoreMiNiWeChatUser extends BaseModel
{
    protected $table = 'store_mini_wechat_user';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'store_uuid',
        'openid',
        'nickname',
        'avatar_url',
        'gender',
        'country',
        'province',
        'city',
        'is_forbidden',
        'language',
        'real_name',
        'mobile',
        'address',
        'longitude',
        'latitude',
        'district',
        'birthday',
        'is_show',
        "channel_uuid",
    ];

    /**
     * 注册渠道
     * @return HasOne
     */
    public function channel(): HasOne
    {
        return $this->hasOne(StoreChannel::class, "uuid", "channel_uuid");
    }
}