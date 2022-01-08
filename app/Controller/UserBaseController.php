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

namespace App\Controller;

use App\Mapping\HttpDataResponse;
use App\Service\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * 用户请求基类
 *
 * Class BaseController
 */
class UserBaseController extends AbstractController
{
	/**
	 * @Inject
	 * @var HttpDataResponse
	 */
	protected $httpResponse;

	/**
	 * @Inject
	 * @var RequestInterface
	 */
	protected $request;

	protected $service;

	public function __construct(UserServiceInterface $userService)
	{
		$this->service = $userService;
	}
}
