<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\Model;

/**
 * 用户端页面
 * Class AdminPagePath
 * @package App\Model\Common
 */
class AdminPagePath extends Model
{
    protected $table = 'admin_page_path';

    public function getTypeAttribute($key): string
    {
        $platform = [1 => '微信小程序', 2 => '微信公众号', '3' => 'H5网页'];

        return $platform[$key];
    }
}