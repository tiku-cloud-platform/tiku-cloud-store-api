<?php
declare(strict_types = 1);

namespace App\Request\Config;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 平台轮播图
 *
 * Class MenuValidate
 * @package App\Request\Store\Config
 */
class BannerValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|max:20',
            'file_uuid' => 'required|uuid|exists:store_platform_file,uuid',
            'type' => 'required',
            'url' => 'required',
            'position_position' => 'required|exists:store_dictionary,uuid',
            'orders' => 'required|integer',
            'is_show' => ['required', 'integer', Rule::in([2, 1])],
            'client_position' => 'required|exists:store_dictionary,uuid',
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => '名称长度超过32个字符',
            'file_uuid.required' => '图标不能为空',
            'file_uuid.uuid' => '图标格式不正确',
            'file_uuid.exists' => '图标不存在',
            'type.required' => '跳转类型不能为空',
            'url.required' => '跳转地址不能为空',
            'position_position.required' => '显示位置不能为空',
            'position_position.exists' => '显示位置不存在',
            'orders.required' => '显示顺序不能为空',
            'orders.integer' => '显示顺序格式不正确',
            'is_show.required' => '显示状态不能为空',
            'is_show.integer' => '显示状态格式不正确',
            'is_show.in' => '显示状态值不正确',
            'client_position.required' => '显示端口不能为空',
            'client_position.exists' => '显示端口不存在',
        ];
    }
}