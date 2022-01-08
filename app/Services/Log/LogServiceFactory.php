<?php

namespace App\Services\Log;

use App\Services\Log\Handler\EmptyHandler;

/**
 * 日志记录
 *
 * class LogServiceFactory
 * @package App\Services\Log
 */
class LogServiceFactory
{
    private $logHandler;

    public function __construct()
    {
        if (env('APP_LOG', false)) {
            $className        = ucfirst(env('APP_LOG_HANDLER'));
            $fullCLassName    = 'App\Services\Log\Handler\\' . $className . 'Handler';
            $this->logHandler = new $fullCLassName();
        } else {
            $this->logHandler = new EmptyHandler();
        }
    }

    /**
     * 记录系统日志
     *
     * @param string $tableName
     * @param array $logInfo
     * @return bool
     */
    public function recordLog(string $tableName, array $logInfo): bool
    {
        $logInfo['created_at'] = date('Y-m-d H:i:s');
        $logInfo['updated_at'] = date('Y-m-d H:i:s');
        $logInfo['deleted_at'] = null;

        return $this->logHandler::createLog((string)$tableName, (array)$logInfo);
    }
}