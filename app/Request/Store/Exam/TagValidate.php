<?php
declare(strict_types = 1);

namespace App\Request\Store\Exam;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 试题分类
 *
 * Class CategoryValidate
 * @package App\Request\Store\Exam
 */
class TagValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|max:10',
            'parent_uuid' => 'sometimes|uuid|exists:store_exam_tag,uuid',
            'is_show'     => ['required', Rule::in([1, 2])],
            'orders'      => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => '名称不能为空',
            'title.max'          => '名称不能超过10个字符',
            'parent_uuid.uuid'   => '上级分类格式不正确',
            'parent_uuid.exists' => '上级分类不存在',
            'is_show.required'   => '显示状态不能为空',
            'is_show.in'         => '显示状态错误',
            'orders.required'    => '显示顺序不能为空',
            'orders.integer'     => '显示顺序格式不正确',
        ];
    }
}