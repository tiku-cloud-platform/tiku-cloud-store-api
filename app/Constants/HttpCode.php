<?php
declare(strict_types=1);

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
