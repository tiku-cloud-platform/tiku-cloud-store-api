<?php

declare(strict_types = 1);

namespace App\Request\User;

use Hyperf\Validation\Request\FormRequest;

/**
 * 绑定用户验证
 * Class BindUserValidate
 * @package App\Request\Store\User
 */
class BindUserValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user' => 'required|json',
            'uuid' => 'required|uuid',
        ];
    }

    public function messages(): array
    {
        return [
            'user.required' => '绑定用户不能为空',
            'user.json'     => '用户格式不正确',
            'uuid.required' => '分组不能为空',
            'uuid.uuid'     => '分组格式不正确',
        ];
    }
}
