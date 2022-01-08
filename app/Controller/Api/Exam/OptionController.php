<?php
declare(strict_types = 1);

namespace App\Controller\Api\Exam;


use App\Controller\UserBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Service\User\Exam\OptionService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 单选试题
 *
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 *     })
 * @Controller(prefix="api/v1/exam/option")
 * Class OptionController
 * @package App\Controller\Api\Exam
 */
class OptionController extends UserBaseController
{
    public function __construct(OptionService $optionService)
    {
        $this->service = $optionService;
        parent::__construct($optionService);
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