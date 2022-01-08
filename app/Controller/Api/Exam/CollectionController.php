<?php
declare(strict_types=1);

namespace App\Controller\Api\Exam;


use App\Controller\UserBaseController;
use App\Service\User\Exam\CollectionService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 试卷
 *
 * @Controller(prefix="api/v1/exam/collection")
 * Class CollectionController
 * @package App\Controller\Api\Exam
 */
class CollectionController extends UserBaseController
{
    public function __construct(CollectionService $collectionService)
    {
        $this->service = $collectionService;
        parent::__construct($collectionService);
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