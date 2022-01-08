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

namespace App\Request\Store\Article;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 分类验证
 *
 * Class FileGroupValidate
 */
class CategoryValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|max:20',
            'parent_uuid' => 'nullable|uuid|exists:store_article_category,uuid',
            'file_uuid'   => 'sometimes|uuid|exists:store_platform_file,uuid',
            'is_show'     => ['required', 'integer', Rule::in([2, 1])],
            'orders'      => 'required|integer',

        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => '名称不能为空',
            'title.max'          => '名称长度超过20',
            'parent_uuid.uuid'   => '上级分类格式错误',
            'parent_uuid.exists' => '上级分类不存在',
            'file_uuid.uuid'     => '封面格式不正确',
            'file_uuid.exists'   => '封面不存在',
            'is_show.required'   => '启用状态不能为空',
            'is_show.integer'    => '状态格式不正确',
            'is_show.in'         => '状态值不正确',
            'orders.required'    => '顺序不能为空',
            'orders.integer'     => '顺序格式不正确',
        ];
    }
}
