<?php
declare(strict_types = 1);

namespace App\Request\User;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 微信用户
 *
 * Class WeChatUserValidate
 * @package App\Request\Store\User
 */
class WeChatUserValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_forbidden' => ['required', 'integer', Rule::in([2, 1])],
        ];
    }

    public function messages(): array
    {
        return [
            'is_forbidden.required' => '账号状态不能为空',
            'is_forbidden.integer'  => '账号状态格式不正确',
            'is_forbidden.in'       => '账号状态值不正确',
        ];
    }
}