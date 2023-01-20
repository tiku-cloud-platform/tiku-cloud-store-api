<?php
declare(strict_types = 1);

namespace App\Controller\File;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Common\UUIDValidate;
use App\Request\File\FileGroupValidate;
use App\Service\File\FileGroupService;
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
    /**
     * @GetMapping(path="group/list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = (new FileGroupService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="parent")
     * @return ResponseInterface
     */
    public function parent(): ResponseInterface
    {
        $items = (new FileGroupService)->serviceParentSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="group/show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate): ResponseInterface
    {
        $bean = (new FileGroupService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="group/create")
     * @param FileGroupValidate $validate
     * @return ResponseInterface
     */
    public function create(FileGroupValidate $validate): ResponseInterface
    {
        $createResult = (new FileGroupService)->serviceCreate($this->request->all());
        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="group/update")
     * @param FileGroupValidate $validate
     * @return ResponseInterface
     */
    public function update(FileGroupValidate $validate): ResponseInterface
    {
        $updateResult = (new FileGroupService)->serviceUpdate($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="group/delete")
     * @return ResponseInterface
     */
    public function destroy(): ResponseInterface
    {
        $deleteResult = (new FileGroupService)->serviceDelete($this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}
