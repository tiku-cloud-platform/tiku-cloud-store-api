<?php
declare(strict_types = 1);

namespace App\Library\File;

use App\Service\Store\File\TokenService;
use Qiniu\Storage\UploadManager;

/**
 * 文件上传
 *
 * Class FileUpload
 * @package App\Library\File
 */
class FileUpload
{
    /**
     * 文件上传驱动
     *
     * @var null
     */
    private $driver = null;

    /**
     * 文件上传token
     *
     * @var string
     */
    private $token = '';

    /**
     * 文件上传配置信息
     *
     * @var array
     */
    private $configArray = [];

    public function __construct()
    {
        $config            = (new TokenService())->serviceUploadToken();
        $this->driver      = $config['driver'];
        $this->token       = $config['token'];
        $this->configArray = $config['values'];
    }

    /**
     * 文件上传
     *
     * @param array $fileArray 待上传文件
     * @return array 上传之后的真实路径
     */
    public function fileUpload(array $fileArray): array
    {
        if ($this->driver == 'qiniu_cloud') {
            return $this->QiNiuCloud((array)$fileArray);
        }
    }

    /**
     * 七牛云文件上传
     *
     * @param array $fileArray 待上传文件的真实路径
     * @return array 上传之后的真实路径
     * @throws \Exception
     */
    private function QiNiuCloud(array $fileArray): array
    {
        $uploadManager = new UploadManager();
        $result        = [];
        foreach ($fileArray as $value) {
            $fileInfo     = pathinfo($value);
            $fileResource = fopen($value, 'rb');
            $uploadResult = $uploadManager->putFile($this->token, md5((string)microtime() . $fileInfo['filename']) . '.' . $fileInfo['extension'],
                $value);
            $result[]     = [
                'remote' => $this->configArray['domain'] . $uploadResult[0]['key'],
                'origin' => $value,
            ];
        }
        return $result;
    }
}