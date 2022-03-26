<?php

declare(strict_types = 1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Scopes;

use App\Mapping\UserInfo;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\Scope;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * 客户端作用域
 *
 * Class ClientScope
 */
class ClientScope implements Scope
{
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    public function apply(Builder $builder, Model $model)
    {
        $header = $this->request->header('Client-Type', '');
        $router = $this->request->getRequestUri();

        if (!empty($header) && in_array($header, ['web_store'])) {
            if ($router !== '/store/user/login') {
                $builder->where('store_uuid', '=', UserInfo::getStoreUserInfo()['store_uuid']);
            } else {
                $builder->where('id', '>', 0);
            }
        } else {
            $builder->where('id', '=', 0);
        }
    }
}
