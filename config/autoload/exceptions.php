<?php

declare(strict_types=1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */
use App\Exception\Handler\DbDataMessageExceptionHandler;
use App\Exception\Handler\FromValidateExceptionHandler;
use App\Exception\Handler\MethodNotAllowedHttpExceptionHandler;
use App\Exception\Handler\NotFundHttpExceptionHandler;

return [
    'handler' => [
        'http' => [
            DbDataMessageExceptionHandler::class,
            FromValidateExceptionHandler::class,
            NotFundHttpExceptionHandler::class,
            MethodNotAllowedHttpExceptionHandler::class,
            App\Exception\Handler\AppExceptionHandler::class,
        ],
    ],
];
