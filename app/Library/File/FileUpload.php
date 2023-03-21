<?php
declare(strict_types = 1);

namespace App\Library\File;

use App\Service\File\TokenService;
use Exception;
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
     * @throws Exception
     */
    public function fileUpload(array $fileArray): array
    {
        if ($this->driver == 'qiniu_cloud') {
            return $this->QiNiuCloud($fileArray);
        }
    }

    /**
     * 七牛云文件上传
     * @param array $fileArray 待上传文件的真实路径
     * @return array 上传之后的真实路径
     * @throws Exception
     */
    private function QiNiuCloud(array $fileArray): array
    {
        $uploadManager = new UploadManager();
        $result        = [];
        foreach ($fileArray as $value) {
            // 检测云平台的配置域名是否和文件的域名一致，如果一致的不进行重传，针对GitHub图片使用file_get_contents()获取超时，默认就不处理了，直接返回。
            if ((parse_url($value)["host"] == parse_url($this->configArray["domain"])["host"])) {
                $result[] = [
                    'remote' => $value,// 云平台地址
                    'origin' => $value,// 原图片地址
                ];
            } else if (in_array(parse_url($value)["host"], ["raw.githubusercontent.com"])) {
                $result[] = [
                    'remote' => $this->configArray["domain"] . "/" . basename($value),
                    'origin' => $value,
                ];
            } else {
                $fileInfo     = pathinfo($value);
                $fileResource = file_get_contents($value);
                $uploadResult = $uploadManager->put($this->token, md5((string)microtime() . $fileInfo['filename']) . '.' . $fileInfo['extension'], $fileResource);
                // 上传失败时，则默认为原图片链接地址。
                if (!empty($uploadResult) && count($uploadResult) > 1 && $uploadResult[1] == null) {
                    $result[] = [
                        'remote' => $this->configArray['domain'] . $uploadResult[0]['key'],
                        'origin' => $value,
                    ];
                } else {
                    $result[] = [
                        'remote' => $value,
                        'origin' => $value,
                    ];
                }
            }
        }
        return $result;
    }
}