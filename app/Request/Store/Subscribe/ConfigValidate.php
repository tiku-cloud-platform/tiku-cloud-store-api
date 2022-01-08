<?php

declare(strict_types = 1);

namespace App\Request\Store\Subscribe;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 微信订阅消息配置验证
 *
 * Class ConfigValidate
 * @package App\Request\Store\Subscribe
 */
class ConfigValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'             => 'required|max:32',
            'template_id'       => 'required|max:100',
            'data'              => 'required',
            'miniprogram_state' => 'required',
            'lang'              => 'required',
            'is_show'           => ['required', 'integer', Rule::in([2, 1])],
            'orders'            => 'required|integer',
            'file_uuid'         => 'uuid|exists:store_platform_file,uuid',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'             => '标题不能为空',
            'title.max'                  => '标题长度超过32个字符',
            'template_id.required'       => '微信模板不能为空',
            'template_id.max'            => '微信模板超过100个字符',
            'data.required'              => '模板参数不能为空',
            'miniprogram_state.required' => '跳转类型不能为空',
            'lang.required'              => '语言类型不能为空',
            'file_uuid.uuid'             => '封面格式不正确',
            'file_uuid.exists'           => '封面不存在',
            'is_show.required'           => '启用状态不能为空',
            'is_show.integer'            => '启用状态格式不正确',
            'is_show.in'                 => '状态值不正确',
            'orders.required'            => '顺序不能为空',
            'orders.integer'             => '顺序格式不正确',
        ];
    }
}
