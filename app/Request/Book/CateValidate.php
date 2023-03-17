<?php
declare(strict_types = 1);

namespace App\Request\Book;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 书籍目录验证
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
            'parent_uuid' => 'nullable|exists:store_book_cate,uuid',
            'title' => 'required|max:32',
            'is_show' => ['required', 'integer', Rule::in([2, 1])],
            'is_home' => ['required', 'integer', Rule::in([2, 1])],
            'orders' => 'required|integer|max:100000000',
        ];
    }

    public function messages(): array
    {
        return [
            'parent_uuid.exists' => '上级目录不存在',
            'title.required' => '书籍名称不能为空',
            'title.max' => '书籍名称长度超过32个字符',
            'is_show.required' => '书籍启用状态不能为空',
            'is_show.integer' => '书籍启用状态格式不正确',
            'is_show.in' => '书籍状态值不正确',
            'is_home.required' => '首页推荐不能为空',
            'is_home.integer' => '首页推荐格式不正确',
            'is_home.in' => '首页推荐值不正确',
            'orders.required' => '排序不能为空',
            'orders.integer' => '排序格式不正确',
            'orders.max' => '排序数字过大',
        ];
    }
}