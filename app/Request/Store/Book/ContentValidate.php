<?php
declare(strict_types=1);

namespace App\Request\Store\Book;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 书籍内容
 * @package App\Request\Store\Book
 */
class ContentValidate extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'store_book_uuid'          => 'required|uuid|exists:store_book,uuid',
			'store_book_category_uuid' => 'required|uuid|exists:store_book_category,uuid',
			'title'                    => 'required|max:32',
			'intro'                    => 'sometimes|max:1000',
			'content'                  => 'required',
			'author'                   => 'required|max:32',
			'tags'                     => 'sometimes|max:32',
			'source'                   => 'required|max:100',
			'is_show'                  => ['required', 'integer', Rule::in([2, 1])],
			'orders'                   => 'required|integer|max:100000000',
		];
	}

	public function messages(): array
	{
		return [
			'store_book_uuid.required'          => '书籍不能为空',
			'store_book_uuid.uuid'              => '书籍格式错误',
			'store_book_uuid.exists'            => '书籍不存在',
			'store_book_category_uuid.required' => '书籍目录不能为空',
			'store_book_category_uuid.uuid'     => '书籍目录格式错误',
			'store_book_category_uuid.exists'   => '书籍目录不存在',
			'title.required'                    => '书籍名称不能为空',
			'title.max'                         => '书籍名称长度超过32个字符',
//			"intro.required"                    => "内容简介不能为空",
			"intro.max"                         => "内容简介最大不能超过1000个字符",
			"content.required"                  => "内容不能为空",
			"author.required"                   => "文章作者不能为空",
			"author.max"                        => "文章作者不能超过32个字符",
			"tags.max"                          => "文章标签不能超过32个字符",
			"source.required"                   => "文章来源不能为空",
			"source.max"                        => "文章来源最大不能超过100字符",
			'is_show.required'                  => '书籍启用状态不能为空',
			'is_show.integer'                   => '书籍启用状态格式不正确',
			'is_show.in'                        => '书籍状态值不正确',
			'orders.required'                   => '排序不能为空',
			'orders.integer'                    => '排序格式不正确',
			'orders.max'                        => '排序数字过大',
		];
	}
}