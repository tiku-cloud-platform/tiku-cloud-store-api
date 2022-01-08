<?php

declare(strict_types=1);

namespace App\Request\Api\Rank;

use Hyperf\Validation\Request\FormRequest;

/**
 * 答题排行榜
 * Class ExamNumberValidate
 * @package App\Request\Api\Rank
 */
class ExamNumberValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number' => 'sometimes|integer|max:100'
        ];
    }

    public function messages(): array
    {
        return [
            'number.integer' => '数量格式不正确',
            'number.max'     => '最大条数不能超过100',
        ];
    }
}
