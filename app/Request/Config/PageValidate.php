<?php
declare(strict_types = 1);

namespace App\Request\Config;

use App\Request\StoreRequestValidate;

/**
 * 商户页面
 */
class PageValidate extends StoreRequestValidate
{
    public function rules()
    {
        return [
            "title" => "required|max:32",
            "path" => "required|max:255",
            "is_show" => "required|integer",
            "remark" => "sometimes|max:50",
        ];
    }

    public function messages(): array
    {
        return [
            "title.required" => "页面名称必填",
            "title.max" => "页面名称长度不能超过32",
            "path.required" => "页面地址必填",
            "path.max" => "页面地址长队不能超过244",
            "is_show.required" => "显示状态必填",
            "is_show.integer" => "显示状态类型错误",
            "remark.max" => "描述长度不能超过100",
        ];
    }
}