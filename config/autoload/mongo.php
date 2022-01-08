<?php
/**
 * MongoDB数据库配置信息
 */
return [
    'host' => env('MONGO_HOST', 'localhost'),
    'port' => env('MONGO_PORT', 27017),
    'database' => env('MONGO_DATABASE', ''),
    'username' => env('MONGO_USERNAME', ''),
    'password' => env('MONGO_PASSWORD', ''),
];