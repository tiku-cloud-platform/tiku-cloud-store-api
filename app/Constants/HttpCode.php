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
namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class HttpCode extends AbstractConstants
{
    /**
     * @Message("服务器内部错误")
     */
    const SERVER_ERROR = 500;

    /**
     * @Message("未授权")
     */
    const NO_AUTH = 403;
}
