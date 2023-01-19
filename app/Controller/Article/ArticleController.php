<?php
declare(strict_types = 1);

namespace App\Controller\Article;


use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Request\Store\Article\ArticleValidate;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Article\ArticleService;
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
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = (new ArticleService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $bean = (new ArticleService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @PostMapping(path="create")
     * @param ArticleValidate $validate
     * @return ResponseInterface
     */
    public function create(ArticleValidate $validate)
    {
        $createResult = (new ArticleService)->serviceCreate($this->request->all());
        return $createResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PostMapping(path="update")
     * @param ArticleValidate $validate
     * @return ResponseInterface
     */
    public function update(ArticleValidate $validate)
    {
        $updateResult = (new ArticleService)->serviceUpdate($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function destroy()
    {
        $deleteResult = (new ArticleService)->serviceDelete($this->request->all());
        return $deleteResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * @PostMapping(path="publish")
     * @return ResponseInterface
     */
    public function publish()
    {
        $updateResult = (new ArticleService)->servicePublish($this->request->all());

        if ($updateResult['code'] == 0) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->response((string)$updateResult['msg']);
    }
}