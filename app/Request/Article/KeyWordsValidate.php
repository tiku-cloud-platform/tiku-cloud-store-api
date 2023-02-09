<?php
declare(strict_types = 1);

namespace App\Request\Article;

use App\Request\StoreRequestValidate;
use Hyperf\Validation\Rule;

/**
 * 文章关键词搜索验证
 */
class KeyWordsValidate extends StoreRequestValidate
{
    public function rules()
    {
        return [
            "title" => "required|max:32",
            "is_show" => ["required", Rule::in([1, 2])],
            "orders" => "required|integer",
        ];
    }

    public function messages(): array
    {
        return [
            "title.required" => "搜索名称不能为空",
            "title.max" => "搜索名称最大长度为32",
            "is_show.required" => "显示状态不能为空",
            "is_show.in" => "显示状态值不正确",
            "orders.required" => "显示顺序不能为空",
            "orders.integer" => "显示状态值不正确",
        ];
    }
}