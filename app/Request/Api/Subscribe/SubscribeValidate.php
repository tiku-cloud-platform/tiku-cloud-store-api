<?php

declare(strict_types = 1);

namespace App\Request\Api\Subscribe;

use Hyperf\Validation\Request\FormRequest;

/**
 * 微信订阅消息验证
 *
 * Class SubscribeValidate
 * @package App\Request\Api\Subscribe
 */
class SubscribeValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'template_uuid' => 'required|uuid',
        ];
    }

    public function messages(): array
    {
        return [
            'template_uuid.required' => '数据编号不能为空',
            'template_uuid.uuid'     => '数据编号不合法',
        ];
    }
}
