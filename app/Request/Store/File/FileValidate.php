<?php

declare(strict_types = 1);
/**
 * This file is part of api
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Request\Store\File;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 文件验证
 *
 * Class FileGroupValidate
 */
class FileValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'storage'         => ['required', Rule::in(['ali_cloud', 'tence_cloud', 'qiniu_cloud'])],
            'file_info'       => 'required',
            'file_group_uuid' => 'required|uuid|exists:store_platform_file_group,uuid',
        ];
    }

    public function messages(): array
    {
        return [
            'storage.required'         => '文件存储方式不能为空',
            'storage.in'               => '文件存储方式不存在',
            'file_info.required'       => '文件信息不能为空',
            'file_group_uuid.required' => '文件所属分类不能为空',
            'file_group_uuid.uuid'     => '文件所属分类不正确',
            'file_group_uuid.exists'   => '文件所属分类不存在',
        ];
    }
}
