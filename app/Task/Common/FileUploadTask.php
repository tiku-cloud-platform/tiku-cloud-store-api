<?php
declare(strict_types=1);

namespace App\Task\Common;

use Hyperf\Task\Annotation\Task;

/**
 * 文件上传
 *
 * Class FileUploadTask
 * @package App\Task\Common
 */
class FileUploadTask
{
    /**
     * 根据传入的文件数组，传递到默认的文件配置平台。
     *
     * @Task()
     * @param array $fileArray 需要上传的文件数组
     * @return array 上传之后的文件绝对路径地址
     */
    public function handle(array $fileArray): array
    {

    }
}