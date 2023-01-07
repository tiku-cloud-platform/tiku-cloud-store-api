<?php
declare(strict_types = 1);

namespace App\Controller\Store\Exam;


use App\Constants\ErrorCode;
use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\Exam\OptionValidate;
use App\Service\Store\Exam\OptionService;
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
 * @Controller(prefix="store/exam/option")
 * Class OptionController
 * @package App\Controller\Store\Exam
 */
class OptionController extends StoreBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = (new OptionService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = (new OptionService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="create")
     * @param OptionValidate $validate
     * @return ResponseInterface
     */
    public function create(OptionValidate $validate)
    {
        // 验证单选题数
        $verifyResult = (new OptionService)->verifyCollectionSum((array)$this->request->all()["collection"]);
        if (!empty($verifyResult["uuid"])) {
            return $this->httpResponse->error($verifyResult, ErrorCode::REQUEST_ERROR, $verifyResult["msg"] . "已超过最大选择题数");
        } else {
            $createResult = (new OptionService)->serviceCreate($this->request->all());
            return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
        }
    }

    /**
     * @PutMapping(path="update")
     * @param OptionValidate $validate
     * @return ResponseInterface
     */
    public function update(OptionValidate $validate)
    {
        // 验证单选题数
        $verifyResult = (new OptionService)->verifyCollectionSum((array)$this->request->all()["collection"], (string)$this->request->all()["uuid"]);
        if (!empty($verifyResult["uuid"])) {
            return $this->httpResponse->error($verifyResult, ErrorCode::REQUEST_ERROR, $verifyResult["msg"] . "已超过最大选择题数");
        } else {
            $updateResult = (new OptionService)->serviceUpdate($this->request->all());
            return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
        }
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = (new OptionService)->serviceDelete($this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}