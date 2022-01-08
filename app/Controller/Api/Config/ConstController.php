<?php
declare(strict_types = 1);

namespace App\Controller\Api\Config;

use App\Controller\UserBaseController;
use App\Service\User\Config\ConstService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 系统常量配置
 * Class ConstController
 * @Controller(prefix="api/v1/config")
 * @package App\Controller\Api\Config
 */
class ConstController extends UserBaseController
{
    public function __construct(ConstService $constService)
    {
        $this->service = $constService;
        parent::__construct($constService);
    }

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = $this->service->serviceSelect((array)$this->request->all());

        return $this->httpResponse->success((array)$items);
    }
}