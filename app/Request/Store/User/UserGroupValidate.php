<?php

declare(strict_types = 1);

namespace App\Request\Store\User;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 用户分组
 *
 * Class UserGroupValidate
 * @package App\Request\Store\User
 */
class UserGroupValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'   => 'required|max:10',
            'is_show' => ['required', Rule::in([1, 2])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => '名称不能为空',
            'title.max'        => '名称不能超过32个字符',
            'is_show.required' => '显示状态不能为空',
            'is_show.in'       => '显示状态错误',
        ];
    }
}
