<?php
declare(strict_types=1);

namespace App\Model\User;

/**
 * 平台内容
 *
 * Class StorePlatformContent
 * @package App\Model\User
 */
class StorePlatformContent extends \App\Model\Common\StorePlatformContent
{
	public $searchFields = [
		'content',
		'title',
	];
}