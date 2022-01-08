<?php
declare(strict_types = 1);

namespace App\Controller\Api\Rank;

use App\Controller\UserBaseController;
use App\Service\User\Rank\ScoreService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 积分排行
 *
 * @Controller(prefix="api/v1/score")
 * Class ScoreRankController
 * @package App\Controller\Api\Rank
 */
class ScoreRankController extends UserBaseController
{
    public function __construct(ScoreService $scoreService)
    {
        $this->service = $scoreService;
        parent::__construct($scoreService);
    }

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = $this->service->serviceGroup((array)$this->request->all());

        return $this->httpResponse->success((array)$items);
    }
}