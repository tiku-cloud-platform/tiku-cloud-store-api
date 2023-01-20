<?php
declare(strict_types = 1);

namespace App\Controller\Sign;

use App\Controller\StoreBaseController;
use App\Request\Sign\ConfigValidate;
use App\Service\Sign\ConfigService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\Auth\StoreAuthMiddleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 签到配置
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="sign/config")
 * Class PageController
 * @package App\Controller\Sign
 */
class SignController extends StoreBaseController
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
     * @param ConfigValidate $validate
     * @return ResponseInterface
     */
    public function show(ConfigValidate $validate): ResponseInterface
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
        $deleteResult = (new ConfigService())->serviceDelete($this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}