<?php
declare(strict_types = 1);

namespace App\Request\Store\Channel;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 统计渠道验证
 * Class GroupValidate
 * @package App\Request\Store\Channel
 */
class GroupValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'   => 'required|max:20',
            'is_show' => ['required', 'integer', Rule::in([2, 1])],
        ];
    }

    public function messages(): array
    {
        return [
            "title.required"   => "分组标题不能为空",
            'title.max'        => '名称长度超过32个字符',
            'is_show.required' => '显示状态不能为空',
            'is_show.integer'  => '显示状态格式不正确',
            'is_show.in'       => '显示状态值不正确',
        ];
    }
}