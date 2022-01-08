<?php
declare(strict_types = 1);

namespace App\Request\Store\Message;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 平台消息内容
 *
 * Class MenuValidate
 * @package App\Request\Store\Config
 */
class ContentValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'                          => 'required|max:20',
            'content'                        => 'required',
            'platform_message_category_uuid' => 'required|uuid|exists:store_platform_message_category,uuid',
            'is_show'                        => ['required', 'integer', Rule::in([2, 1])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'                          => '名称不能为空',
            'title.max'                               => '名称长度超过20',
            'content.max'                             => '文章内容不能为空',
            'platform_message_category_uuid.required' => '文章分类不能为空',
            'platform_message_category_uuid.uuid'     => '文章分类格式不正确',
            'platform_message_category_uuid.exists'   => '文章分类不存在',
            'is_show.required'                        => '显示状态不能为空',
            'is_show.integer'                         => '显示状态格式不正确',
            'is_show.in'                              => '显示状态值不正确',
        ];
    }
}