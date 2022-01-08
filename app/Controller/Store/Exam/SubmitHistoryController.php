<?php

namespace App\Controller\Store\Exam;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\Store\Exam\SubmitHistoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 答题历史
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/exam/submit")
 * class SubmitHistoryController
 * @package App\Controller\Store\Exam
 */
class SubmitHistoryController extends StoreBaseController
{
    public function __construct(SubmitHistoryService $historyService)
    {
        $this->service = $historyService;
        parent::__construct($historyService);
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

    /**
     * @GetMapping(path="show")
     * @return ResponseInterface
     */
    public function show()
    {
        $bean = $this->service->serviceFind((array)$this->request->all());

        return $this->httpResponse->success((array)$bean);
    }
}