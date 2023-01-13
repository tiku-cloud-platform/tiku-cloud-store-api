<?php
declare(strict_types = 1);

namespace App\Mapping;

use Godruoyi\Snowflake\Snowflake;

/**
 * 全局UUID生成器.
 * Class UUID
 */
class UUID
{
    /**
     * 获取全局UUID.
     */
    public static function getUUID(): string
    {
        $snowflake = new Snowflake();
        $md5Value  = strtolower(md5($snowflake->id() . mt_rand(0, 10000000000000)));
        // 8-4-4-4-12
        return substr($md5Value, 0, 8) . '-' .
            substr($md5Value, 8, 4) . '-' .
            substr($md5Value, 12, 4) . '-' .
            substr($md5Value, 14, 4) . '-' .
            substr($md5Value, 20, 12);
    }
}
