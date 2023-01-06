<?php
declare(strict_types = 1);

namespace App\Controller\Store\Config;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\Config\ContentValidate;
use App\Service\Store\Config\PlatformContentService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 平台内容介绍
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/config")
 * Class PlatformContentController
 * @package App\Controller\Store\Config
 */
class ContentController extends StoreBaseController
{
    public function __construct(PlatformContentService $contentService)
    {
        $this->service = $contentService;
        parent::__construct($contentService);
    }

    /**
     * @GetMapping(path="content/list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = $this->service->serviceSelect($this->request->all());

        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="content/show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = $this->service->serviceFind($this->request->all());

        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="content/create")
     * @param ContentValidate $validate
     * @return ResponseInterface
     */
    public function create(ContentValidate $validate)
    {
        $createResult = $this->service->serviceCreate($this->request->all());

        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PostMapping(path="content/update")
     * @param ContentValidate $validate
     * @return ResponseInterface
     */
    public function update(ContentValidate $validate)
    {
        $updateResult = $this->service->serviceUpdate($this->request->all());

        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="content/delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = $this->service->serviceDelete($this->request->all());

        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}