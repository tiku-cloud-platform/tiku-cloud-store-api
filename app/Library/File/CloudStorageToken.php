<?php
declare(strict_types = 1);

namespace App\Library\File;

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
     * @param string $driver
     * @param array $config
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
        $auth = new Auth($config['app_key'], $config['app_secret']);

        return $auth->uploadToken($config['bucket']);
    }
}