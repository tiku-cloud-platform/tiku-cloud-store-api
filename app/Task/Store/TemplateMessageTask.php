<?php
declare(strict_types = 1);

namespace App\Task\Store;

use Hyperf\Task\Annotation\Task;
use Hyperf\Utils\Coroutine;

/**
 * 订阅消息
 *
 * Class TemplateMessageTask
 * @package App\Task\Store
 */
class TemplateMessageTask
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