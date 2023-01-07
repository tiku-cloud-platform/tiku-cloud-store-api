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
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = (new SubmitHistoryService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="show")
     * @return ResponseInterface
     */
    public function show()
    {
        $bean = (new SubmitHistoryService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }
}