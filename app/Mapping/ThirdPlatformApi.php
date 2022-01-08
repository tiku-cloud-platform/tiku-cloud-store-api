<?php
declare(strict_types = 1);

namespace App\Mapping;

/**
 * 第三方平台url
 *
 * Class ThirdPlatformApi
 * @package App\Mapping
 */
class ThirdPlatformApi
{
    /**
     * 微信小程序登录接口
     */
    const WX_MINI_LOGIN_URL = 'https://api.weixin.qq.com/sns/jscode2session?';

    /**
     * 微信小程序Access_Token
     */
    const WX_MINI_ACCESS_TOKEN = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&';

    /**
     * 微信小程序收录页面提交
     */
    const WX_SEARCH_SUBMIT_PAGES = 'https://api.weixin.qq.com/wxa/search/wxaapi_submitpages?access_token=';
}