<?php
declare(strict_types = 1);

namespace App\Request\Store\Score;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 积分配置验证
 *
 * Class ScoreSettingValidate
 * @package App\Request\Store\Score
 */
class ScoreSettingValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'   => 'required|max:20',
            'score'   => 'required',
            'key'     => 'required|exists:store_platform_const_config,value',
            'is_show' => ['required', 'integer', Rule::in([2, 1])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => '名称不能为空',
            'title.max'        => '名称长度超过20',
            'score.required'   => '积分不能为空',
            'key.required'     => '配置key不能为空',
            'key.exists'       => '配置key不存在',
            'is_show.required' => '显示状态不能为空',
            'is_show.integer'  => '显示状态格式不正确',
            'is_show.in'       => '显示状态值不正确',
        ];
    }
}