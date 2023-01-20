<?php
declare(strict_types = 1);

namespace App\Request\Sign;

use App\Request\StoreRequestValidate;
use Hyperf\Validation\Rule;

class ConfigValidate extends StoreRequestValidate
{
    public function rules(): array
    {
        return [
            'num' => "required|integer|max:100|min:1",
            'score' => "required|max:999|min:0",
            'is_show' => ["required", Rule::in([1, 2])],
            'remark' => "sometimes|max:1000",
            "is_continue" => ["required", Rule::in([1, 2])],
        ];
    }

    public function messages(): array
    {
        return [
            "num.required" => "签到天数不能为空",
            "num.integer" => "签到天数必须是整数",
            "number.max" => "签到天数最大为100",
            "is_show.required" => "启用状态不能过为空",
            "is_show.in" => "签到天数格式错误",
            "remark.max" => "签到备注字符不能超过1000",
            "is_continue.required" => "是否为持续签到天数不能为空",
            "is_continue.in" => "是否为持续签到天数格式错误",
        ];
    }
}