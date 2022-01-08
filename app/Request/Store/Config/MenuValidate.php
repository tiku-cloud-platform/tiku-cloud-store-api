<?php
declare(strict_types = 1);

namespace App\Request\Store\Config;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 用户端菜单配置验证
 *
 * Class MenuValidate
 * @package App\Request\Store\Config
 */
class MenuValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'     => 'required|max:20',
            'file_uuid' => 'required|uuid|exists:store_platform_file,uuid',
            'type'      => 'required',
            'url'       => 'required',
            'position'  => 'required',
            'orders'    => 'required|integer',
            'is_show'   => ['required', 'integer', Rule::in([2, 1])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => '菜单名称不能为空',
            'title.max'          => '菜单名称长度超过20',
            'file_uuid.required' => '菜单图标不能为空',
            'file_uuid.uuid'     => '菜单图标格式不正确',
            'file_uuid.exists'   => '菜单图标不存在',
            'type.required'      => '菜单跳转类型不能为空',
            'url.required'       => '菜单跳转地址不能为空',
            'position.required'  => '菜单显示位置不能为空',
            'orders.required'    => '菜单显示顺序不能为空',
            'orders.integer'     => '菜单显示顺序格式不正确',
            'is_show.required'   => '菜单显示状态不能为空',
            'is_show.integer'    => '菜单显示状态格式不正确',
            'is_show.in'         => '菜单显示状态值不正确',
        ];
    }
}