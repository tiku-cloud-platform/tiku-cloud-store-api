<?php
declare(strict_types = 1);

use App\Exception\Handler\DbDataMessageExceptionHandler;
use App\Exception\Handler\DbDuplicateMessageExceptionHandler;
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
            DbDuplicateMessageExceptionHandler::class,
        ],
    ],
];
