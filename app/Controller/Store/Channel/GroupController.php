<?php
declare(strict_types = 1);

namespace App\Controller\Store\Channel;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Channel\GroupValidate;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Store\Channel\GroupService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;


/**
 * 渠道分组
 * Class GroupController
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/channel/group")
 * @package App\Controller\Store\Channel
 */
class GroupController extends StoreBaseController
{
    public function __construct(GroupService $groupService)
    {
        $this->service = $groupService;
        parent::__construct($groupService);
    }

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = $this->service->serviceSelect((array)$this->request->all());

        return $this->httpResponse->success((array)$items);
    }

    /**
     * @PostMapping(path="create")
     * @param GroupValidate $groupValidate
     * @return ResponseInterface
     */
    public function create(GroupValidate $groupValidate): ResponseInterface
    {
        $createResult = $this->service->serviceCreate((array)$this->request->all());
        if ($createResult) {
            return $this->httpResponse->success();
        }

        return $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="update")
     * @param GroupValidate $groupValidate
     * @param UUIDValidate $UUIDValidate
     * @return ResponseInterface
     */
    public function update(GroupValidate $groupValidate, UUIDValidate $UUIDValidate): ResponseInterface
    {
        $updateResult = $this->service->serviceUpdate((array)$this->request->all());

        if ($updateResult) {
            return $this->httpResponse->success();
        }

        return $this->httpResponse->error();
    }

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $UUIDValidate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $UUIDValidate): ResponseInterface
    {
        $bean = $this->service->serviceFind((array)$this->request->all());

        return $this->httpResponse->success((array)$bean);
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy(): ResponseInterface
    {
        $deleteResult = $this->service->serviceDelete((array)$this->request->all());
        if ($deleteResult) {
            return $this->httpResponse->success();
        }

        return $this->httpResponse->error();
    }
}