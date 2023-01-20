<?php
declare(strict_types = 1);

namespace App\Request\Dict;

use App\Request\StoreRequestValidate;

/**
 * 字典管理
 */
class DictValidate extends StoreRequestValidate
{
    public function rules(): array
    {
        return [
            "title" => "required|max:32",
            "value" => "required|max:50",
            "group_uuid" => "required|uuid|exists:store_dictionary_group,uuid",
            "is_show" => "required|integer",
            "remark" => "sometimes|max:50",
        ];
    }

    public function messages(): array
    {
        return [
            "title.required" => "字典名称必填",
            "title.max" => "分组名称长度不能超过32",
            "value.required" => "字典值必填",
            "value.max" => "字典值必填不能超过50",
            "group_uuid.required" => "字典分组必填",
            "group_uuid.uuid" => "字典分组格式错误",
            "group_uuid.exists" => "字典分组不存在",
            "is_show.required" => "显示状态必填",
            "is_show.integer" => "分组类型只能是正数",
            "remark.max" => "描述长度不能超过50",
        ];
    }
}