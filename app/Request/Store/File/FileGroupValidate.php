<?php

declare(strict_types = 1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Request\Store\File;

use Hyperf\Validation\Request\FormRequest;

/**
 * 文件组验证
 *
 * Class FileGroupValidate
 */
class FileGroupValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|max:20',
            'parent_uuid' => 'nullable|uuid',
            'is_show'     => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => '文件组名称不能为空',
            'title.max'        => '文件组名称长度超过20',
            'parent_uuid.uuid' => '文件组上级分类格式错误',
            'is_show.required' => '文件组启用状态不能为空',
            'is_show.integer'  => '文件组启用状态格式不正确',
        ];
    }
}
