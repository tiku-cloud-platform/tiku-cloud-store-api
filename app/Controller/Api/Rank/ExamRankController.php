<?php
declare(strict_types = 1);

namespace App\Controller\Api\Rank;

use App\Controller\UserBaseController;
use App\Request\Api\Rank\ExamNumberValidate;
use App\Service\User\Rank\ExamService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 答题排行榜
 *
 * @Controller(prefix="rank/exam")
 * Class ExamRankController
 * @package App\Controller\Api\Rank
 */
class ExamRankController extends UserBaseController
{
    public function __construct(ExamService $examService)
    {
        $this->service = $examService;
        parent::__construct($examService);
    }

    /**
     * @GetMapping(path="list")
     * @param ExamNumberValidate $numberValidate
     * @return ResponseInterface
     */
    public function index(ExamNumberValidate $numberValidate)
    {
        $items = $this->service->serviceSelect((array)$this->request->all());

        return $this->httpResponse->success((array)$items);
    }
}