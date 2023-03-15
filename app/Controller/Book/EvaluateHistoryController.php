<?php
declare(strict_types = 1);

namespace App\Controller\Book;

use App\Controller\StoreBaseController;
use App\Request\Book\EvaluateHistoryValidate;
use App\Service\Book\EvaluateHistoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\Auth\StoreAuthMiddleware;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 教程点评
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/book/evaluate_history")
 * Class ContentController
 * @package App\Controller\Store\Book
 */
class EvaluateHistoryController extends StoreBaseController
{

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function list(): ResponseInterface
    {
        return $this->httpResponse->success((new EvaluateHistoryService())->serviceSelect($this->request->all()));
    }

    /**
     * @PutMapping(path="update")
     * @param EvaluateHistoryValidate $validate
     * @return ResponseInterface
     */
    public function update(EvaluateHistoryValidate $validate): ResponseInterface
    {
        if ((new EvaluateHistoryService())->serviceUpdate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }
}