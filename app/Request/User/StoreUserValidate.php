<?php
declare(strict_types = 1);

namespace App\Request\User;


use Hyperf\Validation\Request\FormRequest;

/**
 * 商户信息验证
 *
 * Class StoreUserValidate
 * @package App\Request\Store\User
 */
class StoreUserValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|max:20',
            'email'        => 'required|email',
            'old_password' => 'sometimes',
            'new_password' => 'sometimes|confirmed',
            'mobile'       => 'required|mobile',
            'avatar'       => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => '昵称不能为空',
            'name.max'               => '昵称长度不能超过20个字符',
            'email.required'         => '邮箱不能为空',
            'email.email'            => '邮箱格式不正确',
            'new_password.confirmed' => '新密码和确认密码不一致',
            'mobile.require'         => '手机号不能为空',
            'avatar.required'        => '头像不能为空',
        ];
    }
}