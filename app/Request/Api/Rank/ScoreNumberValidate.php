<?php

declare(strict_types=1);

namespace App\Request\Api\Rank;

use Hyperf\Validation\Request\FormRequest;

/**
 * 积分排行验证
 *
 * Class ScoreNumberValidate
 * @package App\Request\Api\Rank
 */
class ScoreNumberValidate extends FormRequest
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
