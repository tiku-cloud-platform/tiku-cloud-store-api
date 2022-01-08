<?php

namespace App\Services\Log\Handler;

use App\Services\Log\LogServiceInterface;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Database;

/**
 * MongoDB日志记录
 *
 * class MongoDbHandler
 * @package App\Services\Log\Handler
 */
class MongoHandler implements LogServiceInterface
{

    public function __construct()
    {
    }

    /**
     * 获取连接对象
     *
     * @return Client
     */
    private static function getConnect(): Client
    {
        $uri = 'mongodb://' . config('mongo.host') . ':' . config('mongo.port') . '/';

        return new Client($uri);
    }

    /**
     * 获取数据库
     *
     * @return Database
     */
    private static function getMongoDb(): Database
    {
        $databaseName = config('mongo.database');

        return self::getConnect()->selectDatabase($databaseName);
    }

    /**
     * 获取数据表
     *
     * @param string $tableName
     * @return Collection
     */
    private static function getCollection(string $tableName): Collection
    {
        return self::getMongoDb()->selectCollection($tableName);
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
        if (self::getCollection((string)$tableName)->insertOne($logInfo)) return true;
        return false;
    }
}