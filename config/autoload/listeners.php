<?php

declare(strict_types = 1);

/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

use App\Listener\ValidatorScoreFactoryResolvedListener;
use App\Listener\ValidatorMobileFactoryResolvedListener;
use App\Listener\ValidatorMoneyFactoryResolvedListener;
use App\Listener\ValidatorTimeFactoryResolvedListener;

return [
    ValidatorMoneyFactoryResolvedListener::class,
    ValidatorMobileFactoryResolvedListener::class,
    ValidatorTimeFactoryResolvedListener::class,
    ValidatorScoreFactoryResolvedListener::class,
];
