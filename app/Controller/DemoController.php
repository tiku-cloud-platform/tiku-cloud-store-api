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

namespace App\Controller;


use App\Task\Store\PagePushTask;
use App\Task\Store\TemplateMessageTask;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\Redis\Redis;
use Hyperf\Task\Task;
use Hyperf\Task\TaskExecutor;
use Hyperf\Utils\ApplicationContext;
use Qiniu\Storage\UploadManager;

/**
 * 演示控制器
 * @Controller(prefix="demo")
 * Class DemoController
 */
class DemoController
{
    /**
     * 测试自动部署
     */
    public function index()
    {
        $container = ApplicationContext::getContainer();
        $exec1     = $container->get(TaskExecutor::class);
        $exec2     = $container->get(TaskExecutor::class);
        try {
            $result1 = $exec1->execute(new Task([PagePushTask::class, 'handle'], [time()]));
            $result2 = $exec2->execute(new Task([TemplateMessageTask::class, 'handle'], [1]));
            var_dump($result1, $result2);
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * @GetMapping(path="get")
     */
    public function read()
    {
        $container = ApplicationContext::getContainer();
        $redis     = $container->get(Redis::class);

        for (; ;) {
//			$value = $redis->lPop('aaa');
            $value = $redis->decr('aaaa');
            if (empty($value) || $value < 0) {
                echo '库存不足';
                break;
            } else {
                echo $value . PHP_EOL;
            }
        }
    }

    /**
     * @GetMapping(path="set")
     */
    public function create()
    {
        $token         = "YWwjHxwQxD-wWl4nlNT_U01t__0pOQliNX5_I_A2:gLRaSAB_S8c5f0_GL3V6koB7tLo=:eyJzY29wZSI6ImRvY3VtZW50ZXMiLCJkZWFkbGluZSI6MTY0NDY0Mzc2MX0=";
        $fileArray     = [
            "https://gitee.com/bruce_qiq/picture/raw/master/2021-12-5/1638677669159-Snipaste_2021-12-05_12-14-03.png",
            "https://gitee.com/bruce_qiq/picture/raw/master/2021-12-5/1638677740749-Snipaste_2021-12-05_12-15-31.png",
            "https://gitee.com/bruce_qiq/picture/raw/master/2021-12-5/1638686190182-Snipaste_2021-12-05_14-36-02.png",
        ];
        $uploadManager = new UploadManager();
        $result        = [];
        foreach ($fileArray as $value) {
            $fileInfo = pathinfo($value);
            var_dump("文件信息", $fileInfo);
//            $fileResource = fopen($value, 'rb');
            $fileResource = file_get_contents($value);
//            var_dump($fileResource);
            $uploadResult = $uploadManager->put($token, md5((string)microtime() . $fileInfo['filename']) . '.' . $fileInfo['extension'], $fileResource);
//            $uploadResult = $uploadManager->putFile($token, $fileInfo['filename'] . '.' . $fileInfo['extension'],
//                $value);
//            $uploadResult = $uploadManager->putFile($token, md5((string)microtime() . $fileInfo['filename']) . '.' . $fileInfo['extension'],
//                $value);
            var_dump("上传结果", $uploadResult);
        }
        return $result;
    }

}
