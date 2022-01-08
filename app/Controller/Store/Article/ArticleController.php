<?php
declare(strict_types = 1);

namespace App\Controller\Store\Article;


use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Article\ArticleValidate;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Store\Article\ArticleService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 文章管理
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/article")
 * Class ArticleController
 * @package App\Controller\Store\Article
 */
class ArticleController extends StoreBaseController
{
    public function __construct(ArticleService $articleService)
    {
        $this->service = $articleService;
        parent::__construct($articleService);
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
     * @param ArticleValidate $validate
     * @return ResponseInterface
     */
    public function create(ArticleValidate $validate)
    {
        $createResult = $this->service->serviceCreate((array)$this->request->all());

        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PostMapping(path="update")
     * @param ArticleValidate $validate
     * @return ResponseInterface
     */
    public function update(ArticleValidate $validate)
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

    /**
     * @PostMapping(path="publish")
     * @return ResponseInterface
     */
    public function publish()
    {
        $updateResult = $this->service->servicePublish((array)$this->request->all());

        if ($updateResult['code'] == 0) {
            return $this->httpResponse->success();
        }

        return $this->httpResponse->response((string)$updateResult['msg']);
    }
}