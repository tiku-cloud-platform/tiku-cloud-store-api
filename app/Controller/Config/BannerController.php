<?php
declare(strict_types = 1);

namespace App\Controller\Config;


use App\Constants\DataConfig;
use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Common\UUIDValidate;
use App\Request\Config\BannerValidate;
use App\Service\Config\BannerService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 平台轮播图
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/config")
 * Class BannerController
 * @package App\Controller\Store\Config
 */
class BannerController extends StoreBaseController
{
    /**
     * 轮播图列表
     * @GetMapping(path="banner/list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = (new BannerService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * 轮播图显示位置配置
     * @GetMapping(path="banner/position_config")
     * @return ResponseInterface
     * @deprecated
     */
    public function positionConfig(): ResponseInterface
    {
        return $this->httpResponse->success(DataConfig::bannerClientType());
    }

    /**
     * 轮播图数据详情
     * @GetMapping(path="banner/show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = (new BannerService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * 轮播图创建
     * @PostMapping(path="banner/create")
     * @param BannerValidate $validate
     * @return ResponseInterface
     */
    public function create(BannerValidate $validate)
    {
        $createResult = (new BannerService)->serviceCreate($this->request->all());
        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * 轮播图更新
     * @PutMapping(path="banner/update")
     * @param BannerValidate $validate
     * @return ResponseInterface
     */
    public function update(BannerValidate $validate)
    {
        $updateResult = (new BannerService)->serviceUpdate($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * 轮播图删除
     * @DeleteMapping(path="banner/delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = (new BannerService)->serviceDelete($this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}