<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Mapping\HttpDataResponse;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * 用户请求基类.
 *
 * Class BaseController
 */
class StoreBaseController extends AbstractController
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
}
