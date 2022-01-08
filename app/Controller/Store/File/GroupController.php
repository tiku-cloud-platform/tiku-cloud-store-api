<?php

declare(strict_types = 1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Controller\Store\File;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\File\FileGroupValidate;
use App\Service\Store\File\FileGroupService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 文件组
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/file")
 * Class GroupController
 */
class GroupController extends StoreBaseController
{
    public function __construct(FileGroupService $fileGroupService)
    {
        $this->service = $fileGroupService;
        parent::__construct($fileGroupService);
    }

    /**
     * @GetMapping(path="group/list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = $this->service->serviceSelect((array)$this->request->all());

        return $this->httpResponse->success((array)$items);
    }

    /**
     * @GetMapping(path="parent")
     * @return ResponseInterface
     */
    public function parent(): ResponseInterface
    {
        $items = $this->service->serviceParentSelect((array)$this->request->all());

        return $this->httpResponse->success((array)$items);
    }

    /**
     * @GetMapping(path="group/show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = $this->service->serviceFind((array)$this->request->all());

        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="group/create")
     * @param FileGroupValidate $validate
     * @return ResponseInterface
     */
    public function create(FileGroupValidate $validate)
    {
        $createResult = $this->service->serviceCreate((array)$this->request->all());

        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="group/update")
     * @param FileGroupValidate $validate
     * @return ResponseInterface
     */
    public function update(FileGroupValidate $validate)
    {
        $updateResult = $this->service->serviceUpdate((array)$this->request->all());

        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="group/delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = $this->service->serviceDelete((array)$this->request->all());

        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}
