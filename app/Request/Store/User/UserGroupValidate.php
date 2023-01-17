<?php

declare(strict_types = 1);

namespace App\Request\Store\User;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 会员等级
 * Class UserGroupValidate
 * @package App\Request\Store\User
 */
class UserGroupValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|max:10',
            "score" => "required|min:0.01|max:10000",
            "file_uuid" => "required|uuid|exists:store_platform_file,uuid",
            'is_show' => ['required', Rule::in([1, 2])],
            'is_default' => ['required', Rule::in([1, 2])],
            "remark" => "sometimes|max:100"
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '名称不能为空',
            'title.max' => '名称不能超过32个字符',
            "score.required" => "所需积分不能为空",
            "score.max" => "等级积分最大不能超过10000",
            "score.min" => "等级积分最小不能低于0.01",
            'file_uuid.required' => '等级icon不能为空',
            'file_uuid.uuid' => '等级icon格式不正确',
            'file_uuid.exists' => '等级icon不存在',
            'is_show.required' => '启用状态不能为空',
            'is_show.in' => '启用状态错误',
            'is_default.required' => '是否默认不能为空',
            'is_default.in' => '是否默认状态错误',
            'remark.max' => '会员等级描述不能超过100个字符',
        ];
    }
}
