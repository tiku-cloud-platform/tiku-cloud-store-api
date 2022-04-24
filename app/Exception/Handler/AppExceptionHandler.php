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
use App\Constants\HttpCode;
use App\Constants\LogKey;
use App\Services\Log\LogServiceFactory;
use Cassandra\Exception\ValidationException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(StdoutLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof ValidationException) {
            echo $throwable->getMessage();
        }
        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        $this->logger->error($throwable->getTraceAsString());

        $data = json_encode([
            'code'    => ErrorCode::REQUEST_ERROR,
            'message' => env('APP_ENV') == 'dev' ? $throwable->getMessage() . $throwable->getFile() . $throwable->getLine() : ErrorCode::getMessage(ErrorCode::REQUEST_ERROR),
            'data'    => [],
        ]);
        // 添加数据异常记录
        (new LogServiceFactory())->recordLog((string)LogKey::APP_ERROR_LOG, (array)[
            'app_error_msg'  => $throwable->getMessage(),
            'app_error_file' => $throwable->getFile(),
            'app_error_line' => $throwable->getLine(),
        ]);
        return $response->withStatus(HttpCode::SERVER_ERROR)->withBody(new SwooleStream($data));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
