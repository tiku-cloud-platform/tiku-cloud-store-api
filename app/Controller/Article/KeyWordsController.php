<?php
declare(strict_types = 1);

namespace App\Controller\Article;

use App\Controller\StoreBaseController;
use App\Request\Article\KeyWordsValidate;
use App\Service\Article\KeyWordsService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use App\Middleware\Auth\StoreAuthMiddleware;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 文章关键词搜索
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="article/keywords")
 * Class KeyWordsController
 * @package App\Controller\Article
 */
class KeyWordsController extends StoreBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->httpResponse->success((new KeyWordsService())->serviceSelect($this->request->all()));
    }

    /**
     * @PostMapping(path="create")
     * @param KeyWordsValidate $validate
     * @return ResponseInterface
     */
    public function create(KeyWordsValidate $validate): ResponseInterface
    {
        if ((new KeyWordsService())->serviceCreate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }

    /**
     * @GetMapping(path="show")
     * @return ResponseInterface
     */
    public function show(): ResponseInterface
    {
        return $this->httpResponse->success((new KeyWordsService())->serviceFind($this->request->all()));
    }

    /**
     * @PutMapping(path="update")
     * @param KeyWordsValidate $validate
     * @return ResponseInterface
     */
    public function update(KeyWordsValidate $validate): ResponseInterface
    {
        if ((new KeyWordsService())->serviceUpdate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }

    /**
     * @DeleteMapping(path="delete")
     * @return ResponseInterface
     */
    public function delete(): ResponseInterface
    {
        if ((new KeyWordsService())->serviceDelete($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }
}