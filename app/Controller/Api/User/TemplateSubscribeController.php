<?php
declare(strict_types = 1);

namespace App\Controller\Api\User;

use App\Controller\UserBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Request\Api\Subscribe\SubscribeValidate;
use App\Service\User\User\TemplateSubscribeService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 微信订阅消息记录
 *
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 *     })
 * @Controller(prefix="api/v1/user/subcribe")
 * Class TemplateSubscribeController
 * @package App\Controller\Api\User
 */
class TemplateSubscribeController extends UserBaseController
{
    public function __construct(TemplateSubscribeService $subscribeService)
    {
        $this->service = $subscribeService;
        parent::__construct($subscribeService);
    }

    /**
     * @PostMapping(path="create")
     * @param SubscribeValidate $subscribeValidate
     * @return ResponseInterface
     */
    public function create(SubscribeValidate $subscribeValidate)
    {
        $result = $this->service->serviceCreate((array)$this->request->all());

        if ($result) return $this->httpResponse->success();
        return $this->httpResponse->error();
    }
}