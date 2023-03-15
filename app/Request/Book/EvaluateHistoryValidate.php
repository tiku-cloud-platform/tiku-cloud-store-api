<?php
declare(strict_types = 1);

namespace App\Request\Book;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 教程点评审核验证
 */
class EvaluateHistoryValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid' => 'required|uuid|exists:store_book_evaluate_history,uuid',
            'is_show' => ['required', 'integer', Rule::in([2, 1])],
        ];
    }

    public function messages(): array
    {
        return [
            'uuid.required' => '编号不能为空',
            'uuid.uuid' => '编号格式不正确',
            'uuid.exists' => '编号不存在',
            'is_show.required' => '显示状态不能为空',
            'is_show.integer' => '显示状态格式不正确',
            'is_show.in' => '显示状态值不正确',
        ];
    }
}