<?php
declare(strict_types = 1);

namespace App\Controller\Store\Config;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\Config\ConstantValidate;
use App\Service\Store\Config\ConstantConfigService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 商户端常量配置
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/config")
 * Class ConstantConfigController
 */
class ConstantConfigController extends StoreBaseController
{
    /**
     * @GetMapping(path="constant/list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = (new ConstantConfigService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="constant/show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = (new ConstantConfigService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="constant/create")
     * @param ConstantValidate $validate
     * @return ResponseInterface
     */
    public function create(ConstantValidate $validate)
    {
        $createResult = (new ConstantConfigService)->serviceCreate($this->request->all());
        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="constant/update")
     * @param ConstantValidate $validate
     * @return ResponseInterface
     */
    public function update(ConstantValidate $validate)
    {
        $updateResult = (new ConstantConfigService)->serviceUpdate($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="constant/delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = (new ConstantConfigService)->serviceDelete($this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}
