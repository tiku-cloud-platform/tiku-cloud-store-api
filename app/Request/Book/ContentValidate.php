<?php
declare(strict_types = 1);

namespace App\Request\Book;

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
            'store_book_uuid' => 'required|uuid|exists:store_book,uuid',
            'store_book_category_uuid' => 'required|uuid|exists:store_book_category,uuid',
            'title' => 'required|max:32',
            'intro' => 'sometimes|max:1000',
            'content' => 'required',
            'author' => 'required|max:32',
            'tags' => 'sometimes|max:32',
            'source' => 'required|max:100',
            'is_show' => ['required', 'integer', Rule::in([2, 1])],
            'content_type' => ['required', 'integer', Rule::in([2, 1])],
            'orders' => 'required|integer|max:100000000',
            "read_score" => "required|max:1000|min:0.01",
            "share_score" => "required|max:1000|min:0.01",
            "click_score" => "required|max:1000|min:0.01",
            "collection_score" => "required|max:1000|min:0.01",
            "read_expend_score" => "required|max:1000|min:0.01",
        ];
    }

    public function messages(): array
    {
        return [
            'store_book_uuid.required' => '书籍不能为空',
            'store_book_uuid.uuid' => '书籍格式错误',
            'store_book_uuid.exists' => '书籍不存在',
            'store_book_category_uuid.required' => '书籍目录不能为空',
            'store_book_category_uuid.uuid' => '书籍目录格式错误',
            'store_book_category_uuid.exists' => '书籍目录不存在',
            'title.required' => '书籍名称不能为空',
            'title.max' => '书籍名称长度超过32个字符',
//			"intro.required"                    => "内容简介不能为空",
            "intro.max" => "内容简介最大不能超过1000个字符",
            "content.required" => "内容不能为空",
            "author.required" => "文章作者不能为空",
            "author.max" => "文章作者不能超过32个字符",
            "tags.max" => "文章标签不能超过32个字符",
            "source.required" => "文章来源不能为空",
            "source.max" => "文章来源最大不能超过100字符",
            'is_show.required' => '书籍启用状态不能为空',
            'is_show.integer' => '书籍启用状态格式不正确',
            'is_show.in' => '书籍状态值不正确',
            'content_type.in' => '文档类型不正确',
            'orders.required' => '排序不能为空',
            'orders.integer' => '排序格式不正确',
            'orders.max' => '排序数字过大',
            "read_score.required" => "阅读积分不能为空",
            "read_score.max" => "阅读积分最大为1000",
            "read_score.min" => "阅读积分最大为0.01",
            "share_score.required" => "分享积分不能为空",
            "share_score.max" => "分享积分最大为1000",
            "share_score.min" => "分享积分最大为0.01",
            "click_score.required" => "点赞积分不能为空",
            "click_score.max" => "点赞积分最大为1000",
            "click_score.min" => "点赞积分最大为0.01",
            "collection_score.required" => "收藏积分不能为空",
            "collection_score.max" => "收藏积分最大为1000",
            "collection_score.min" => "收藏积分最大为0.01",
            "read_expend_score.required" => "阅读消耗积分不能为空",
            "read_expend_score.max" => "阅读消耗积分最大为1000",
            "read_expend_score.min" => "阅读消耗积分最大为0.01",
        ];
    }
}