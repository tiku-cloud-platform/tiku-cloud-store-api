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
 * 平台参数配置.
 *
 * Class ConstantValidate
 */
class SettingValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'  => 'required|max:20',
            'type'   => 'required',
            'values' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'  => '配置名称不能为空',
            'title.max'       => '配置名称长度超过20',
            'type.required'   => '配置类型不能为空',
            'values.required' => '配置值不能为空',
        ];
    }
}
