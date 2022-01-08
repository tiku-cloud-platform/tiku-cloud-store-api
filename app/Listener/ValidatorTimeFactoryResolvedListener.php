<?php
declare(strict_types = 1);

namespace App\Listener;


use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;

class ValidatorTimeFactoryResolvedListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            ValidatorFactoryResolved::class
        ];
    }

    public function process(object $event)
    {
        /** @var ValidatorFactoryInterface $validatorFactory */
        $validatorFactory = $event->validatorFactory;
        $validatorFactory->extend('time', function ($attribute, $value, $parameters, $validator) {
            $timeArray = explode(':', $value);
            if (count($timeArray) == 3 && ($timeArray[0] >= 00 && $timeArray[0] <= 23) && ($timeArray[1] >= 00 && $timeArray[1] <= 59) && ($timeArray[2] >= 00 && $timeArray[2] <= 59)) {
                return true;
            }
            return false;
        });
        $validatorFactory->replacer('time', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':time', $attribute, $message);
        });
    }
}