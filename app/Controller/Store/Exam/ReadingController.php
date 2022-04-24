<?php
declare(strict_types=1);

namespace App\Controller\Store\Exam;


use App\Constants\ErrorCode;
use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\Exam\ReadingValidate;
use App\Service\Store\Exam\ReadingService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 单选试题
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/exam/reading")
 * Class ReadingController
 * @package App\Controller\Store\Exam
 */
class ReadingController extends StoreBaseController
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
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = $this->service->serviceFind((array)$this->request->all());

        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="create")
     * @param ReadingValidate $validate
     * @return ResponseInterface
     */
    public function create(ReadingValidate $validate)
    {
        $verifyResult = $this->service->verifyCollectionSum((array)$this->request->all()["collection"]);
        if (!empty($verifyResult["uuid"])) {
            return $this->httpResponse->error((array)$verifyResult, (int)ErrorCode::REQUEST_ERROR, (string)$verifyResult["msg"] . "已超过最大问答题数");
        } else {
            $createResult = $this->service->serviceCreate((array)$this->request->all());
            return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
        }
    }

    /**
     * @PutMapping(path="update")
     * @param ReadingValidate $validate
     * @return ResponseInterface
     */
    public function update(ReadingValidate $validate)
    {
        $verifyResult = $this->service->verifyCollectionSum((array)$this->request->all()["collection"], (string)$this->request->all()["uuid"]);
        if (!empty($verifyResult["uuid"])) {
            return $this->httpResponse->error((array)$verifyResult, (int)ErrorCode::REQUEST_ERROR, (string)$verifyResult["msg"] . "已超过最大问答题数");
        } else {
            $updateResult = $this->service->serviceUpdate((array)$this->request->all());
            return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
        }
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = $this->service->serviceDelete((array)$this->request->all());

        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}