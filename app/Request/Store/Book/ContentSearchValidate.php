<?php
declare(strict_types=1);

namespace App\Request\Store\Book;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 书籍内容检索验证
 * @package App\Request\Store\Book
 */
class ContentSearchValidate extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			"store_book_uuid" => "required",
		];
	}

	public function messages(): array
	{
		return [
			"store_book_uuid.required" => "书籍不能为空",
		];
	}
}