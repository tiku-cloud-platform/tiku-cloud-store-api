<?php
declare(strict_types = 1);

namespace App\Request\Attache;

use Hyperf\Validation\Request\FormRequest;

/**
 * 附件编号验证
 */
class UuidValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "uuid" => "required|exists:store_attache,uuid",
        ];
    }

    public function messages(): array
    {
        return [
            "uuid.required" => "附件编号不能为空",
            "uuid.exists" => "附件编号不存在",
        ];
    }
}