<?php

declare(strict_types = 1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Mapping;

use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;
use RedisException;

/**
 * Redis客户端
 *
 * Class RedisClient
 */
class RedisClient
{
    public $redisClient;

    public function __construct()
    {
        $container         = ApplicationContext::getContainer();
        $this->redisClient = $container->get(Redis::class);
    }

    public static function getInstance()
    {
        return (new self())->redisClient;
    }

    /**
     * 生成缓存
     *
     * @param string $prefix 缓存前缀
     * @param string $name 缓存名称
     * @param int $expireTime 有效时长
     * @param array $cacheInfo 缓存数据
     * @return bool
     * @throws RedisException
     */
    public static function create(string $prefix, string $name, array $cacheInfo, int $expireTime = 0): bool
    {
        $redis = (new self())->redisClient;

        if ($expireTime < 1) {
            return $redis->set($prefix . $name, json_encode($cacheInfo, JSON_UNESCAPED_UNICODE));
        }
        return $redis->setex($prefix . $name, $expireTime, json_encode($cacheInfo, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 更新缓存
     *
     * @param string $prefix 缓存前缀
     * @param string $name 缓存名称
     * @param int $expireTime 有效时长
     * @param array $cacheInfo 缓存数据
     * @return bool
     * @throws RedisException
     */
    public static function update(string $prefix, string $name, array $cacheInfo, int $expireTime = 0): bool
    {
        $redis = (new self())->redisClient;

        if ($expireTime < 1) {
            return $redis->set($prefix . $name, json_encode($cacheInfo, JSON_UNESCAPED_UNICODE));
        }
        return $redis->setex($prefix . $name, $expireTime, json_encode($cacheInfo, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 获取缓存
     *
     * @param string $prefix 缓存前缀
     * @param string $name 缓存名
     * @return array 缓存信息
     */
    public static function get(string $prefix, string $name): array
    {
        $redis     = (new self())->redisClient;
        $cacheInfo = $redis->get($prefix . $name);

        if (!empty($cacheInfo)) return json_decode($cacheInfo, true);
        return [];
    }

    /**
     * 删除缓存
     *
     * @param string $prefix 缓存前缀
     * @param string $name 缓存名称
     * @return int
     */
    public static function delete(string $prefix, string $name): int
    {
        $redis = (new self())->redisClient;

        return $redis->del($prefix . $name);
    }
}
