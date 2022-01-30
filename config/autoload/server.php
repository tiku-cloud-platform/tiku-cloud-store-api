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

use Hyperf\Server\Event;
use Hyperf\Server\Server;
use Swoole\Constant;

return [
    'mode'      => SWOOLE_PROCESS,
    'servers'   => [
        [
            'name'                  => 'http',
            'type'                  => Server::SERVER_HTTP,
            'host'                  => '0.0.0.0',
            'port'                  => (int)env('HTTP_PORT'),
            'sock_type'             => SWOOLE_SOCK_TCP,
            'callbacks'             => [
                Event::ON_REQUEST => [Hyperf\HttpServer\Server::class, 'onRequest'],
            ],
            'daemonize'             => 0,
            'task_worker_num'       => swoole_cpu_num(),
            'task_enable_coroutine' => false,
        ],
    ],
    'settings'  => [
        Constant::OPTION_ENABLE_COROUTINE    => true,
        Constant::OPTION_WORKER_NUM          => swoole_cpu_num(),
        Constant::OPTION_PID_FILE            => BASE_PATH . '/runtime/hyperf.pid',
        Constant::OPTION_OPEN_TCP_NODELAY    => true,
        Constant::OPTION_MAX_COROUTINE       => 100000,
        Constant::OPTION_OPEN_HTTP2_PROTOCOL => true,
        Constant::OPTION_MAX_REQUEST         => 100000,
        Constant::OPTION_SOCKET_BUFFER_SIZE  => 2 * 1024 * 1024,
        Constant::OPTION_BUFFER_OUTPUT_SIZE  => 2 * 1024 * 1024,
        Constant::OPTION_TASK_WORKER_NUM     => swoole_cpu_num(),
    ],
    'callbacks' => [
        Event::ON_WORKER_START => [Hyperf\Framework\Bootstrap\WorkerStartCallback::class, 'onWorkerStart'],
        Event::ON_PIPE_MESSAGE => [Hyperf\Framework\Bootstrap\PipeMessageCallback::class, 'onPipeMessage'],
        Event::ON_WORKER_EXIT  => [Hyperf\Framework\Bootstrap\WorkerExitCallback::class, 'onWorkerExit'],
        Event::ON_TASK         => [Hyperf\Framework\Bootstrap\TaskCallback::class, 'onTask'],
        Event::ON_FINISH       => [Hyperf\Framework\Bootstrap\FinishCallback::class, 'onFinish'],
    ],
];
