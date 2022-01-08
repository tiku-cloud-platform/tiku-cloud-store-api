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
        $container = ApplicationContext::getContainer();
        $redis     = $container->get(Redis::class);

        for ($i = 1; $i < 1001; $i++) {
            $value = $redis->lPush('aaa', $i);
            echo $value . PHP_EOL;
        }
    }
}
