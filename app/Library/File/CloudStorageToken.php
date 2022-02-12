<?php
declare(strict_types = 1);

namespace App\Library\File;

use App\Constants\CacheKey;
use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;
use Qiniu\Auth;

/**
 * 云存储token
 *
 * Class CloudStorageToken
 * @package App\Mapping
 */
class CloudStorageToken
{
    /**
     * 获取第三方对象存储token信息
     *
     * @param string $driver 文件上传方式
     * @param array $config 云存储配置信息，包含一些key，secret等信息。
     * @return array
     * @author kert
     */
    public function getToken(string $driver, array $config): array
    {
        $info = [
            'token' => '',
        ];
        if ($driver == 'qiniu_cloud') {
            $info['token'] = $this->qiNiuCloud((array)$config);
        }

        return $info;
    }

    /**
     * 七牛云对象存储
     *
     * @param array $config
     * @return string
     * @author kert
     */
    public function qiNiuCloud(array $config): string
    {
        // 检测Redis配置信息
        $container = ApplicationContext::getContainer();
        $redis     = $container->get(Redis::class);
        $token     = $redis->get(CacheKey::CLOUD_PLATFORM_FILE_TOKEN . $config["app_key"]);

        if (empty($token)) {
            $auth  = new Auth($config['app_key'], $config['app_secret']);
            $token = $auth->uploadToken($config['bucket']);
            $redis->set(CacheKey::CLOUD_PLATFORM_FILE_TOKEN . $config["app_key"], $token, 7000);
        }

        return $token;
    }
}