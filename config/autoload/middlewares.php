<?php
declare(strict_types = 1);

use App\Middleware\CorsMiddleware;
use Hyperf\Validation\Middleware\ValidationMiddleware;

return [
    'http' => [
        CorsMiddleware::class,
        ValidationMiddleware::class,
    ],
];
