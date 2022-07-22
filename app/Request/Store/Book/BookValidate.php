<?php
declare(strict_types=1);

namespace App\Request\Store\Book;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 书籍基础信息验证
 * @package App\Request\Store\Book
 */
class BookValidate extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'title'     => 'required|max:32',
			'file_uuid' => 'sometimes|uuid|exists:store_platform_file,uuid',
			'intro'     => 'nullable|max:1000',
			'author'    => 'required|max:20',
			"tags"      => "nullable|max:32",
			'source'    => 'required|max:20',
			'level'     => ['required', 'integer', Rule::in([1, 2, 3, 4, 5])],
			'is_show'   => ['required', 'integer', Rule::in([2, 1])],
			'orders'    => 'required|integer|max:100000000',
		];
	}

	public function messages(): array
	{
		return [
			'title.required'   => '书籍名称不能为空',
			'title.max'        => '书籍名称长度超过32个字符',
			'file_uuid.uuid'   => '书籍封面格式不正确',
			'file_uuid.exists' => '书籍封面不存在',
			"intro.max"        => "书籍简介不能超过1000个字符",
			'author.required'  => '书籍作者不能为空',
			'author.max'       => '书籍作者长度超过20个字符',
			"tags.max"         => "数据标签不能超过32个字符",
			'source.required'  => '书籍来源不能为空',
			'source.max'       => '书籍来源长度超过20个字符',
			'is_show.required' => '书籍启用状态不能为空',
			'is_show.integer'  => '书籍启用状态格式不正确',
			'is_show.in'       => '书籍状态值不正确',
			'level.required'   => '内容难度不能为空',
			'level.integer'    => '内容难度格式不正确',
			'level.in'         => '内容难度值不正确',
			'orders.required'  => '排序不能为空',
			'orders.integer'   => '排序格式不正确',
			'orders.max'       => '排序数字过大',
		];
	}
}