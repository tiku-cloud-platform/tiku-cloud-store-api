<?php
declare(strict_types = 1);

namespace App\Mapping;

use App\Service\User\Platform\SettingService;

/**
 * 缓存信息
 *
 * Class SettingCache
 * @package App\Mapping
 */
class SettingCache
{
    /**
     * 根据key获取请求参数
     *
     * @param string $key
     * @return array
     */
    public static function getSetting(string $key): array
    {
        return (new SettingService())->serviceFind((array)['type' => $key]);
    }
}