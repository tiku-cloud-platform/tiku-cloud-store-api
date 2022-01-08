<?php

declare(strict_types=1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Exception\Handler;

use App\Constants\ErrorCode;
use App\Constants\LogKey;
use App\Mapping\DataFormatter;
use App\Services\Log\LogServiceFactory;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\MethodNotAllowedHttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Di\Annotation\Inject;
use Throwable;

/**
 * 请求方法不被允许异常.
 *
 * Class NotFundHttpExceptionHandler
 */
class MethodNotAllowedHttpExceptionHandler extends ExceptionHandler
{
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof MethodNotAllowedHttpException) {
            $data = json_encode([
                'code' => empty($throwable->getCode()) ? ErrorCode::REQUEST_ERROR : $throwable->getCode(),
                'message' => '请求方法不被允许',
                'data' => [],
            ]);
            (new LogServiceFactory())->recordLog((string)LogKey::HTTP_METHOD_ERROR_LOG, (array)[
                'app_error_msg' => $throwable->getMessage(),
                'app_error_file' => $throwable->getFile(),
                'app_error_line' => $throwable->getLine(),
                'request_url' => $this->request->fullUrl(),
                'request_real_ip' => DataFormatter::getClientIp((array)$this->request->getServerParams()),
                'request_method' => $this->request->getMethod(),
                'request_data' => json_encode($this->request->all(), JSON_UNESCAPED_UNICODE),
            ]);
            $this->stopPropagation();
            return $response->withStatus(405)->withBody(new SwooleStream($data));
        }

        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
