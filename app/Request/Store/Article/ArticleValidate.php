<?php
declare(strict_types=1);

namespace App\Request\Store\Article;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 文章验证
 *
 * Class ArticleValidate
 * @package App\Request\Store\Article
 */
class ArticleValidate extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'title'                 => 'required|max:32',
			'article_category_uuid' => 'required|uuid|exists:store_article_category,uuid',
			'file_uuid'             => 'sometimes|uuid|exists:store_platform_file,uuid',
			'content'               => 'required',
			'publish_date'          => 'required|date',
			'author'                => 'required|max:20',
			'source'                => 'required|max:20',
			'is_show'               => ['required', 'integer', Rule::in([2, 1])],
			'is_top'                => ['required', 'integer', Rule::in([2, 1])],
			'orders'                => 'required|integer',
		];
	}

	public function messages(): array
	{
		return [
			'title.required'                 => '标题不能为空',
			'title.max'                      => '标题长度超过32个字符',
			'article_category_uuid.required' => '分类不能为空',
			'article_category_uuid.uuid'     => '分类格式不正确',
			'article_category_uuid.exists'   => '分类不存在',
			'file_uuid.uuid'                 => '封面格式不正确',
			'file_uuid.exists'               => '封面不存在',
			'content.required'               => '内容不能为空',
			'publish_date.required'          => '发布日期不能为空',
			'publish_date.date'              => '发布日期格式不正确',
			'author.required'                => '作者不能为空',
			'author.max'                     => '作者长度超过20个字符',
			'source.required'                => '来源不能为空',
			'source.max'                     => '来源长度超过20个字符',
			'is_show.required'               => '启用状态不能为空',
			'is_show.integer'                => '启用状态格式不正确',
			'is_show.in'                     => '状态值不正确',
			'is_top.required'                => '置顶状态不能为空',
			'is_top.integer'                 => '置顶状态格式不正确',
			'is_top.in'                      => '置顶值不正确',
			'orders.required'                => '顺序不能为空',
			'orders.integer'                 => '顺序格式不正确',
		];
	}
}