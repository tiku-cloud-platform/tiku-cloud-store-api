<?php
declare(strict_types = 1);

namespace App\Controller\Store\Channel;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Channel\ChannelValidate;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Store\Channel\ChannelService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 统计渠道
 * Class ChannelController
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/channel")
 * @package App\Controller\Store\Channel
 */
class ChannelController extends StoreBaseController
{
    public function __construct(ChannelService $channelService)
    {
        $this->service = $channelService;
        parent::__construct($channelService);
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
     * @param ChannelValidate $channelValidate
     * @return ResponseInterface
     */
    public function create(ChannelValidate $channelValidate): ResponseInterface
    {
        $createResult = $this->service->serviceCreate((array)$this->request->all());
        if ($createResult) {
            return $this->httpResponse->success();
        }

        return $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="update")
     * @param ChannelValidate $channelValidate
     * @param UUIDValidate $UUIDValidate
     * @return ResponseInterface
     */
    public function update(ChannelValidate $channelValidate, UUIDValidate $UUIDValidate): ResponseInterface
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