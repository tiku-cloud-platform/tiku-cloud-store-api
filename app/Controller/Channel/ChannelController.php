<?php
declare(strict_types = 1);

namespace App\Controller\Channel;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Channel\ChannelValidate;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Channel\ChannelService;
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
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = (new ChannelService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @PostMapping(path="create")
     * @param ChannelValidate $channelValidate
     * @return ResponseInterface
     */
    public function create(ChannelValidate $channelValidate): ResponseInterface
    {
        $createResult = (new ChannelService)->serviceCreate($this->request->all());
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
        $updateResult = (new ChannelService)->serviceUpdate($this->request->all());
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
        $bean = (new ChannelService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy(): ResponseInterface
    {
        $deleteResult = (new ChannelService)->serviceDelete($this->request->all());
        if ($deleteResult) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }
}