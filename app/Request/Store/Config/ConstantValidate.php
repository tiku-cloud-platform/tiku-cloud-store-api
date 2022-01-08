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

namespace App\Request\Store\Config;

use Hyperf\Validation\Request\FormRequest;

/**
 * 商户端常量配置验证
 *
 * Class ConstantValidate
 */
class ConstantValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'    => 'required|max:20',
            'describe' => 'required|max:100',
            'value'    => 'required|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => '配置名称不能为空',
            'title.max'         => '配置名称长度超过20',
            'describe.required' => '配置描述不能为空',
            'describe.max'      => '配置描述长度超过100',
            'value.required'    => '配置值不能为空',
            'value.max'         => '配置值长度超过20',
        ];
    }
}
