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

namespace App\Listener;

use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;

/**
 * 验证器监听器.
 *
 * Class ValidatorScoreFactoryResolvedListener
 */
class ValidatorScoreFactoryResolvedListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            ValidatorFactoryResolved::class,
        ];
    }

    public function process(object $event)
    {
        /** @var ValidatorFactoryInterface $validatorFactory */
        $validatorFactory = $event->validatorFactory;
        // 注册了 money 验证器
        $validatorFactory->extend('score', function ($attribute, $value, $parameters, $validator) {
            $value = (double)$value;
            return (is_int($value) || is_double($value)) ? true : false;
        });
        $validatorFactory->replacer('score', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':score', $attribute, $message);
        });
    }
}
