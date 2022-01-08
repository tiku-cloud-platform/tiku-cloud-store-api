<?php

declare(strict_types=1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */
namespace App\Request\Store\Common;

use Hyperf\Validation\Request\FormRequest;

/**
 * 删除时uuid验证
 *
 * Class UUIDJsonValidate
 */
class UUIDJsonValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid' => 'required|json',
        ];
    }

    public function messages(): array
    {
        return [
            'uuid.required' => '数据编号不能为空',
            'uuid.json' => '数据编号不合法',
        ];
    }
}
