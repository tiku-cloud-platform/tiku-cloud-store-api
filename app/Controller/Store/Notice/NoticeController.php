<?php
declare(strict_types = 1);

namespace App\Controller\Store\Notice;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\Store\Notice\NoticeService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 商户公告
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/notice")
 * Class NoticeController
 * @package App\Controller\Store\Notice
 */
class NoticeController extends StoreBaseController
{
    public function __construct(NoticeService $noticeService)
    {
        $this->service = $noticeService;
        parent::__construct($noticeService);
    }

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = $this->service->serviceSelect((array)$this->request->all());

        return $this->httpResponse->success((array)$items);
    }
}