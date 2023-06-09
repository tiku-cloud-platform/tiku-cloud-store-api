<?php
declare(strict_types = 1);

namespace App\Request\Article;


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
            'title' => 'required|max:32',
            'content_desc' => 'required|max:100',
            'article_category_uuid' => 'required|uuid|exists:store_article_category,uuid',
            'file_uuid' => 'sometimes|uuid|exists:store_platform_file,uuid',
            'content' => 'required',
            'publish_date' => 'required|date',
            'author' => 'required|max:20',
            'source' => 'required|max:20',
            'is_show' => ['required', 'integer', Rule::in([2, 1])],
            'is_top' => ['required', 'integer', Rule::in([2, 1])],
//            'content_type' => ['required', 'integer', Rule::in([2, 1])],
            'orders' => 'required|integer',
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
            'title.required' => '标题不能为空',
            'title.max' => '标题长度超过32个字符',
            "content_desc.required" => "文章简介不能为空",
            "content_desc.max" => "文章简介长度超过100个字符",
            'article_category_uuid.required' => '分类不能为空',
            'article_category_uuid.uuid' => '分类格式不正确',
            'article_category_uuid.exists' => '分类不存在',
            'file_uuid.uuid' => '封面格式不正确',
            'file_uuid.exists' => '封面不存在',
            'content.required' => '内容不能为空',
            'publish_date.required' => '发布日期不能为空',
            'publish_date.date' => '发布日期格式不正确',
            'author.required' => '作者不能为空',
            'author.max' => '作者长度超过20个字符',
            'source.required' => '来源不能为空',
            'source.max' => '来源长度超过20个字符',
            'is_show.required' => '启用状态不能为空',
            'is_show.integer' => '启用状态格式不正确',
            'is_show.in' => '状态值不正确',
            'is_top.required' => '置顶状态不能为空',
            'is_top.integer' => '置顶状态格式不正确',
            'is_top.in' => '置顶值不正确',
            'content_type.in' => '文档类型不正确',
            'orders.required' => '顺序不能为空',
            'orders.integer' => '顺序格式不正确',
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