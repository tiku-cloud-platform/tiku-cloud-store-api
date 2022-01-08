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

namespace App\Listener;

use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;

/**
 * 验证器监听器.
 *
 * Class ValidatorMoneyFactoryResolvedListener
 */
class ValidatorMoneyFactoryResolvedListener implements ListenerInterface
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
		$validatorFactory->extend('money', function ($attribute, $value, $parameters, $validator) {
			$pregResult = preg_match('/^[0-9]{1,20}(\.[0-9]{1,2})?$/', $value);
			// true则返回错误信息;false则不返回错误，表示验证通过
			return empty($pregResult) ? true : false;
		});
		$validatorFactory->replacer('money', function ($message, $attribute, $rule, $parameters) {
			return str_replace(':money', $attribute, $message);
		});
	}
}
