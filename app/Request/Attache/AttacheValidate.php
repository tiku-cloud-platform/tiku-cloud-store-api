<?php
declare(strict_types = 1);

namespace App\Request\Attache;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 附件管理验证
 * @package App\Request\Store\Book
 */
class AttacheValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file_uuid' => 'required|uuid|exists:store_platform_file,uuid',
            'cate_uuid' => 'required|exists:store_attache_cate,uuid',
            'title' => 'required|max:32',
            "download_number" => "required|min:0|max:100000000",
            "content" => "required|max:255",
            "type" => ['required', 'integer', Rule::in([1, 2, 3, 4, 5, 6])],
            'is_show' => ['required', 'integer', Rule::in([2, 1])],
            'orders' => 'required|integer|max:100000000',
            "attache_content" => "required|max:65535",
            "score" => "required|between:1,1000",
            "url" => "nullable|max:255",
        ];
    }

    public function messages(): array
    {
        return [
            'cate_uuid.required' => '附件分类不能为空',
            'cate_uuid.exists' => '附件分类不存在',
            'title.required' => '附件名称不能为空',
            'title.max' => '附件名称长度超过32个字符',
            'file_uuid.required' => '附件封面格式不正确',
            'file_uuid.uuid' => '附件封面格式不正确',
            'file_uuid.exists' => '附件封面不存在',
            "download_number.required" => "下载次数不能为空",
            "download_number.min" => "下载次数最小为0",
            "download_number.max" => "下载次数最小为100000000",
            "content.required" => "附件内容不能为空",
            "content.max" => "附件内容最大长度为255",
            "type.required" => "附件类型不能为空",
            "type.in" => "附件类型格式不正确",
            'is_show.required' => '启用状态不能为空',
            'is_show.integer' => '启用状态格式不正确',
            'is_show.in' => '状态值不正确',
            'orders.required' => '排序不能为空',
            'orders.integer' => '排序格式不正确',
            'orders.max' => '排序数字过大',
            "attache_content.required" => "附件介绍不能为空",
            "attache_content.max" => "附件介绍最大长度65535",
            "score" => "积分不能为空",
            "score.between" => "积分值只能在1-1000之间",
            "url.max" => "跳转地址最大长度255",
        ];
    }
}