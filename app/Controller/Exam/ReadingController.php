<?php
declare(strict_types = 1);

namespace App\Controller\Exam;

use App\Constants\ErrorCode;
use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\Exam\ReadingValidate;
use App\Service\Exam\ReadingService;
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
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = (new ReadingService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = (new ReadingService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="create")
     * @param ReadingValidate $validate
     * @return ResponseInterface
     */
    public function create(ReadingValidate $validate)
    {
        $verifyResult = (new ReadingService)->verifyCollectionSum((array)$this->request->all()["collection"]);
        if (!empty($verifyResult["uuid"])) {
            return $this->httpResponse->error($verifyResult, ErrorCode::REQUEST_ERROR, $verifyResult["msg"] . "已超过最大问答题数");
        } else {
            $createResult = (new ReadingService)->serviceCreate($this->request->all());
            return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
        }
    }

    /**
     * @PutMapping(path="update")
     * @param ReadingValidate $validate
     * @return ResponseInterface
     */
    public function update(ReadingValidate $validate): ResponseInterface
    {
        $verifyResult = (new ReadingService)->verifyCollectionSum((array)$this->request->all()["collection"], (string)$this->request->all()["uuid"]);
        if (!empty($verifyResult["uuid"])) {
            return $this->httpResponse->error($verifyResult, ErrorCode::REQUEST_ERROR, $verifyResult["msg"] . "已超过最大问答题数");
        } else {
            $updateResult = (new ReadingService)->serviceUpdate($this->request->all());
            return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
        }
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = (new ReadingService)->serviceDelete($this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * 更新基础字段
     * @PutMapping(path="edit")
     * @return ResponseInterface
     */
    public function edit(): ResponseInterface
    {
        if ((new ReadingService())->serviceEdit($this->request->all()) > 0) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->success();
    }
}