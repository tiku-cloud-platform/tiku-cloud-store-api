<?php
declare(strict_types = 1);

namespace App\Request\Store\Message;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 平台消息分类
 *
 * Class MenuValidate
 * @package App\Request\Store\Config
 */
class CategoryValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'     => 'required|max:10',
            'file_uuid' => 'required|uuid|exists:store_platform_file,uuid',
            'orders'    => 'required|integer',
            'is_show'   => ['required', 'integer', Rule::in([2, 1])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => '名称不能为空',
            'title.max'          => '名称长度超过10',
            'file_uuid.required' => '图标不能为空',
            'file_uuid.uuid'     => '图标格式不正确',
            'file_uuid.exists'   => '图标不存在',
            'orders.required'    => '显示顺序不能为空',
            'orders.integer'     => '显示顺序格式不正确',
            'is_show.required'   => '显示状态不能为空',
            'is_show.integer'    => '显示状态格式不正确',
            'is_show.in'         => '显示状态值不正确',
        ];
    }
}