<?php
declare(strict_types = 1);

namespace App\Controller\Store\Exam;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Request\Store\Exam\CollectionValidate;
use App\Service\Store\Exam\CollectionService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 试卷
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/exam/collection")
 * Class CategoryController
 * @package App\Controller\Store\Exam
 */
class CollectionController extends StoreBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = (new CollectionService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="relation")
     * @return ResponseInterface
     */
    public function relation()
    {
        $items = (new CollectionService)->serviceRelationSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = (new CollectionService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="create")
     * @param CollectionValidate $validate
     * @return ResponseInterface
     */
    public function create(CollectionValidate $validate)
    {
        $createResult = (new CollectionService)->serviceCreate($this->request->all());
        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PutMapping(path="update")
     * @param CollectionValidate $validate
     * @return ResponseInterface
     */
    public function update(CollectionValidate $validate)
    {
        $updateResult = (new CollectionService)->serviceUpdate($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = (new CollectionService)->serviceDelete((array)$this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @GetMapping(path="reading_list")
     * @return ResponseInterface
     */
    public function reading()
    {
        $items = (new CollectionService)->serviceReadingList($this->request->all());
        return $this->httpResponse->success($items);
    }
}