<?php
declare(strict_types=1);

namespace App\Task\Store;

use Hyperf\Task\Annotation\Task;
use Hyperf\Utils\Coroutine;

/**
 * 微信小程序页面收录提交
 *
 * Class PagePushTask
 * @package App\Task\Store
 */
class PagePushTask
{
    /**
     * @Task
     *
     * @param $cid
     * @return array
     */
    public function handle($cid)
    {
        return [
            'work.id' => $cid,
            'task.id' => Coroutine::id(),
        ];
    }
}