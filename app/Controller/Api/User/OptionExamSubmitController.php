<?php
declare(strict_types=1);

namespace App\Controller\Api\User;


use App\Controller\UserBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Service\User\User\ExamSubmitHistoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;

/**
 * 试题提交
 *
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 *     })
 * @Controller(prefix="api/v1/user/exam")
 * Class OptionExamSubmitController
 * @package App\Controller\Api\User
 */
class OptionExamSubmitController extends UserBaseController
{
    public function __construct(ExamSubmitHistoryService $historyService)
    {
        $this->service = $historyService;
        parent::__construct($historyService);
    }

    /**
     * @GetMapping(path="option/index")
     * @return ResponseInterface
     */
    public function optionIndex(): ResponseInterface
    {
        $items = $this->service->serviceSelect((array)$this->request->all());

        return $this->httpResponse->success((array)$items);
    }

    /**
     * @PostMapping(path="option/create")
     * @return ResponseInterface
     */
    public function optionCreate(): ResponseInterface
    {
        $requestParams = $this->request->all();
        $requestParams['type'] = 1;// 单选试题
        $createResult = $this->service->serviceCreate((array)$requestParams);

        if ($createResult) {
            $score = Context::get('score');
            return $this->httpResponse->success((array)$score);
        }

        return $this->httpResponse->error();
    }
}