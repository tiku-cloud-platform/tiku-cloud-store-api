<?php
declare(strict_types = 1);

namespace App\Request\Store\Exam;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 问答试题
 *
 * Class ReadingValidate
 * @package App\Request\Store\Exam
 */
class ReadingValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'               => 'required|max:1000',
            'tips_expend_score'   => 'required|score',
            'answer_income_score' => 'required|score',
            'is_show'             => ['required', Rule::in([1, 2])],
            'is_search'           => ['required', Rule::in([1, 2])],
            'level'               => 'required|integer|max:5',
            'category'            => 'sometimes',
            'tag'                 => 'sometimes',
            'collection'          => 'sometimes',
            'source_url'          => 'nullable',
            'video_url'           => 'nullable|max:255',
            'source_author'       => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'               => '题目不能为空',
            'title.max'                    => '题目不能超过1000个字符',
            'video_url.max'                => '视频链接不能超过500个字符',
            'tips_expend_score.required'   => '解析消耗积分不能为空',
            'answer_income_score.required' => '答案奖励积分不能为空',
            'is_show.required'             => '显示状态不能为空',
            'is_show.in'                   => '显示状态错误',
            'is_search.required'           => '搜索状态不能为空',
            'is_search.in'                 => '搜索状态错误',
            'level.required'               => '难度不能为空',
            'level.integer'                => '难度格式不正确',
            'level.max'                    => '难度格式不正确',
        ];
    }
}