<?php

namespace App\Services\Log;

/**
 * 日志接口
 */
interface LogServiceInterface
{
    /**
     * 创建日志
     *
     * @param string $tableName
     * @param array $logInfo
     * @return bool
     */
    public static function createLog(string $tableName, array $logInfo): bool;
}