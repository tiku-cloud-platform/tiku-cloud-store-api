<?php
declare(strict_types=1);

namespace App\Listener;


use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;

class ValidatorMobileFactoryResolvedListener implements ListenerInterface
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
		$validatorFactory->extend('mobile', function ($attribute, $value, $parameters, $validator) {
			$pregResult = preg_match('/^[1](([3][0-9])|([4][5-9])|([5][0-3,5-9])|([6][5,6])|([7][0-8])|([8][0-9])|([9][1,8,9]))[0-9]{8}$/', $value);
			return empty($pregResult) ? false : true;
		});
		$validatorFactory->replacer('mobile', function ($message, $attribute, $rule, $parameters) {
			return str_replace(':mobile', $attribute, $message);
		});
	}
}