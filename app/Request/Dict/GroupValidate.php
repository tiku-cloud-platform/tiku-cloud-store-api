<?php
declare(strict_types = 1);

namespace App\Request\Dict;

use App\Request\StoreRequestValidate;

/**
 * 字典分组验证
 */
class GroupValidate extends StoreRequestValidate
{
    public function rules(): array
    {
        return [
            "title" => "required|max:32",
            "code" => "required|regex:/[A-Za-z0-9]+/i",
            "is_show" => "required|integer",
            "remark" => "sometimes|max:50",
        ];
    }

    public function messages(): array
    {
        return [
            "title.required" => "分组名称必填",
            "title.max" => "分组名称长度不能超过32",
            "code.required" => "分组标识必填",
            "code.regex" => "分组标识必须是字母或者数字",
            "is_show.required" => "显示状态必填",
            "is_show.integer" => "分组类型只能是正数",
            "remark.max" => "描述长度不能超过50",
        ];
    }
}