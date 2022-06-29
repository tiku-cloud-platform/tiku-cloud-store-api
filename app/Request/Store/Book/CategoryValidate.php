<?php
declare(strict_types=1);

namespace App\Request\Store\Book;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 书籍目录验证
 * @package App\Request\Store\Book
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
			'store_book_uuid' => 'required|uuid|exists:store_book,uuid',
			'parent_uuid'     => 'sometimes|uuid|exists:store_book_category,uuid',
			'title'           => 'required|max:32',
			'is_show'         => ['required', 'integer', Rule::in([2, 1])],
			'orders'          => 'required|integer|max:100000000',
		];
	}

	public function messages(): array
	{
		return [
			'store_book_uuid.required' => '书籍不能为空',
			'store_book_uuid.uuid'     => '书籍格式错误',
			'store_book_uuid.exists'   => '书籍不存在',
			'parent_uuid.uuid'         => '上级目录格式不正确',
			'parent_uuid.exists'       => '上级目录不存在',
			'title.required'           => '书籍名称不能为空',
			'title.max'                => '书籍名称长度超过32个字符',
			'is_show.required'         => '书籍启用状态不能为空',
			'is_show.integer'          => '书籍启用状态格式不正确',
			'is_show.in'               => '书籍状态值不正确',
			'orders.required'          => '排序不能为空',
			'orders.integer'           => '排序格式不正确',
			'orders.max'               => '排序数字过大',
		];
	}
}