<?php
declare(strict_types = 1);

namespace App\Request\Book;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 教程基础信息验证
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
            'title' => 'required|max:32',
            'file_uuid' => 'sometimes|uuid|exists:store_platform_file,uuid',
            'cate_uuid' => 'required|uuid|exists:store_book_cate,uuid',
            'intro' => 'nullable|max:65535',
            "content_desc" => "required|max:64",
            'author' => 'required|max:100',
            "tags" => "nullable|max:100",
            'source' => 'required|max:100',
            'version' => 'required|max:20',
            'level' => ['required', 'integer', Rule::in([1, 2, 3, 4, 5])],
            'is_show' => ['required', 'integer', Rule::in([2, 1])],
            'is_recommend' => ['required', 'integer', Rule::in([2, 1])],
            'orders' => 'required|integer|max:100000000',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '教程名称不能为空',
            'title.max' => '教程名称长度超过32个字符',
            "content_desc.required" => "教程概要不能为空",
            "content_desc.max" => "教程概要不能超过64个字符",
            'file_uuid.uuid' => '教程封面格式不正确',
            'file_uuid.exists' => '教程封面不存在',
            'cate_uuid.required' => '教程分类不能为空',
            'cate_uuid.uuid' => '教程分类不存在',
            'cate_uuid.exists' => '教程分类不存在',
            "intro.max" => "教程简介过长",
            'author.required' => '教程作者不能为空',
            'author.max' => '教程作者长度超过100个字符',
            "tags.max" => "书籍标签不能超过100个字符",
            'source.required' => '教程来源不能为空',
            'source.max' => '教程来源长度超过100个字符',
            'version.required' => '版本号不能为空',
            'version.max' => '版本号最大20个字符',
            'is_show.required' => '教程启用状态不能为空',
            'is_show.integer' => '教程启用状态格式不正确',
            'is_show.in' => '教程状态值不正确',
            'is_recommend.required' => '是否推荐不能为空',
            'is_recommend.integer' => '是否推荐类型错误',
            'is_recommend.in' => '是否推荐值错误',
            'level.required' => '内容难度不能为空',
            'level.integer' => '内容难度格式不正确',
            'level.in' => '内容难度值不正确',
            'orders.required' => '排序不能为空',
            'orders.integer' => '排序格式不正确',
            'orders.max' => '排序数字过大',
        ];
    }
}