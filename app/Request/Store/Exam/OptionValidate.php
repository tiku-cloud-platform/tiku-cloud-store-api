<?php
declare(strict_types = 1);

namespace App\Request\Store\Exam;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 单选试题
 *
 * Class OptionValidate
 * @package App\Request\Store\Exam
 */
class OptionValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'               => 'required|max:1000',
            'file_uuid'           => 'sometimes|uuid|exists:store_platform_file,uuid',
            'tips_expend_score'   => 'required|score',
            'answer_income_score' => 'required|score',
            'option_item'         => 'required',
            'is_show'             => ['required', Rule::in([1, 2])],
            'level' => 'required|integer|max:5',
            'category'            => 'sometimes',
            'tag'                 => 'sometimes',
            'collection'          => 'sometimes',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'               => '题目不能为空',
            'title.max'                    => '题目不能超过1000个字符',
            'file_uuid.uuid'               => '封面格式不正确',
            'file_uuid.exists'             => '封面图片不存在',
            'tips_expend_score.required'   => '解析消耗积分不能为空',
            'answer_income_score.required' => '答案奖励积分不能为空',
            'option_item.required'         => '选项不能为空',
            'is_show.required'             => '显示状态不能为空',
            'is_show.in'                   => '显示状态错误',
            'level.required'               => '难度不能为空',
            'level.integer'                => '难度格式不正确',
            'level.max'                    => '难度格式不正确',
        ];
    }
}