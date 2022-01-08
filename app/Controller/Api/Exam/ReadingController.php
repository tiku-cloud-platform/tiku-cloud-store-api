<?php
declare(strict_types = 1);

namespace App\Controller\Api\Exam;

use App\Controller\UserBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Service\User\Exam\ReadingService;
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
 * @Controller(prefix="api/v1/exam/reading")
 * Class ReadingController
 * @package App\Controller\Api\Exam
 */
class ReadingController extends UserBaseController
{
    public function __construct(ReadingService $readingService)
    {
        $this->service = $readingService;
        parent::__construct($readingService);
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
        $items = $this->service->serviceFind((array)$this->request->all());

        return $this->httpResponse->success((array)$items);
    }
}