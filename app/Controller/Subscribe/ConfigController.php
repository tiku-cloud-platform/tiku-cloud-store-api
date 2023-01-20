<?php
declare(strict_types = 1);

namespace App\Controller\Subscribe;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Common\UUIDValidate;
use App\Request\Subscribe\ConfigValidate;
use App\Service\Subscribe\ConfigService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 微信订阅消息配置
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/subscribe/config")
 * Class ConfigController
 * @package App\Controller\Store\Subscribe
 */
class ConfigController extends StoreBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = (new ConfigService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate): ResponseInterface
    {
        $bean = (new ConfigService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="create")
     * @param ConfigValidate $validate
     * @return ResponseInterface
     */
    public function create(ConfigValidate $validate): ResponseInterface
    {
        $createResult = (new ConfigService)->serviceCreate($this->request->all());
        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PostMapping(path="update")
     * @param ConfigValidate $validate
     * @return ResponseInterface
     */
    public function update(ConfigValidate $validate): ResponseInterface
    {
        $updateResult = (new ConfigService)->serviceUpdate($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy(): ResponseInterface
    {
        $deleteResult = (new ConfigService)->serviceDelete($this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * 发送微信小程序订阅消息
     * @PostMapping(path="mini_send")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function send(UUIDValidate $validate): ResponseInterface
    {
        $sendResult = (new ConfigService)->serviceSend($this->request->all());
        return $this->httpResponse->success($sendResult);
        if (!$sendResult["code"]) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->response((string)$sendResult["msg"]);
    }
}