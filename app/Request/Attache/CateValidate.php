<?php
declare(strict_types = 1);

namespace App\Request\Attache;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 附件分类验证
 * @package App\Request\Store\Book
 */
class CateValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_uuid' => 'nullable|exists:store_attache_cate,uuid',
            'title' => 'required|max:32',
            'is_show' => ['required', 'integer', Rule::in([2, 1])],
            'orders' => 'required|integer|max:100000000',
        ];
    }

    public function messages(): array
    {
        return [
            'parent_uuid.exists' => '上级目录不存在',
            'title.required' => '分类名称不能为空',
            'title.max' => '分类名称长度超过32个字符',
            'is_show.required' => '分类启用状态不能为空',
            'is_show.integer' => '分类启用状态格式不正确',
            'is_show.in' => '分类状态值不正确',
            'orders.required' => '排序不能为空',
            'orders.integer' => '排序格式不正确',
            'orders.max' => '排序数字过大',
        ];
    }
}