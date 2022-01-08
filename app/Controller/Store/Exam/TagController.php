<?php
declare(strict_types = 1);

namespace App\Controller\Store\Exam;


use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\Exam\TagValidate;
use App\Service\Store\Exam\TagService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 试题知识点
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/exam/tag")
 * Class CategoryController
 * @package App\Controller\Store\Exam
 */
class TagController extends StoreBaseController
{
    public function __construct(TagService $tagService)
    {
        $this->service = $tagService;
        parent::__construct($tagService);
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
     * @GetMapping(path="parent")
     * @return ResponseInterface
     */
    public function parent(): ResponseInterface
    {
        $items = $this->service->serviceParentSelect((array)$this->request->all());

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
     * @param TagValidate $validate
     * @return ResponseInterface
     */
    public function create(TagValidate $validate)
    {
        $createResult = $this->service->serviceCreate((array)$this->request->all());

        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="update")
     * @param TagValidate $validate
     * @return ResponseInterface
     */
    public function update(TagValidate $validate)
    {
        $updateResult = $this->service->serviceUpdate((array)$this->request->all());

        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
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