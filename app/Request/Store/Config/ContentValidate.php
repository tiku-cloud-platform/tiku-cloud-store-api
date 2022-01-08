<?php
declare(strict_types = 1);

namespace App\Request\Store\Config;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 用户端内容配置验证
 *
 * Class MenuValidate
 * @package App\Request\Store\Config
 */
class ContentValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'    => 'required|max:32',
            'position' => 'required|integer',
            'content'  => 'required',
            'is_show'  => ['required', 'integer', Rule::in([2, 1])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => '标题不能为空',
            'title.max'         => '标题长度超过32',
            'position.required' => '显示位置不能为空',
            'position.integer'  => '显示位置格式不正确',
            'content.required'  => '内容不能为空',
            'is_show.required'  => '显示状态不能为空',
            'is_show.integer'   => '显示状态格式不正确',
            'is_show.in'        => '显示状态值不正确',
        ];
    }
}