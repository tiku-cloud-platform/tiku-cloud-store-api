<?php

namespace App\Services\Log\Handler;

use App\Services\Log\LogServiceInterface;

/**
 * 空日志驱动
 *
 * class EmptyHandler
 * @package App\Services\Log\Handler
 */
class EmptyHandler implements LogServiceInterface
{

    public function __construct()
    {
    }

    /**
     * 创建日志
     *
     * @param string $tableName
     * @param array $logInfo
     * @return bool
     */
    public static function createLog(string $tableName, array $logInfo): bool
    {
        return true;
    }
}