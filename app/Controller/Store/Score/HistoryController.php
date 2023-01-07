<?php
declare(strict_types = 1);

namespace App\Controller\Store\Score;


use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\Store\Score\ScoreHistoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 积分历史
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/score/history")
 * Class HistoryController
 * @package App\Controller\Store\Score
 */
class HistoryController extends StoreBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = (new ScoreHistoryService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}