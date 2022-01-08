<?php

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class LogKey extends AbstractConstants
{
    /**
     * @Message("数据库查询日志")
     */
    const DB_QUERY_LOG = 'db_query_log';

    /**
     * @Message("系统异常日志")
     */
    const APP_ERROR_LOG = 'app_error_log';

    /**
     * @Message("数据异常")
     */
    const DB_ERROR_LOG = 'db_error_log';

    /**
     * @Message("表单请求异常")
     */
    const FORM_VALIDATE_LOG = 'form_validate_log';

    /**
     * @Message("http请求方法异常")
     */
    const HTTP_METHOD_ERROR_LOG = 'http_method_error_log';

    /**
     * @Message("http请求地址异常")
     */
    const HTTP_URL_ERROR_LOG = 'http_url_error_log';
}