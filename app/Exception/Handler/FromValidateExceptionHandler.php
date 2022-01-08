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
use App\Services\Log\LogServiceFactory;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 表单验证异常处理器
 *
 * Class FromValidateExceptionHandler
 */
class FromValidateExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof ValidationException) {
            $data = json_encode([
                'code' => empty($throwable->getCode()) ? ErrorCode::REQUEST_ERROR : $throwable->getCode(),
                'message' => $throwable->validator->errors()->first(),
                'data' => [],
            ]);
            (new LogServiceFactory())->recordLog((string)LogKey::FORM_VALIDATE_LOG, (array)[
                'app_error_msg' => $throwable->getMessage(),
                'app_error_file' => $throwable->getFile(),
                'app_error_line' => $throwable->getLine(),
            ]);
            $this->stopPropagation();
            return $response->withStatus(422)->withBody(new SwooleStream($data));
        }

        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
