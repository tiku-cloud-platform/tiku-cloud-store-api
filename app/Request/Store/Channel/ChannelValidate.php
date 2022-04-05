<?php
declare(strict_types = 1);

namespace App\Request\Store\Channel;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 统计渠道验证
 * Class ChannelValidate
 * @package App\Request\Store\Channel
 */
class ChannelValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'              => 'required|max:20',
            'is_show'            => ['required', 'integer', Rule::in([2, 1])],
            'channel_group_uuid' => 'required|uuid|exists:store_channel_group,uuid',
            'file_uuid'          => 'sometimes|uuid|exists:store_platform_file,uuid',
            "remark"             => "sometimes|max:100"
        ];
    }

    public function messages(): array
    {
        return [
            "title.required"              => "渠道标题不能为空",
            'title.max'                   => '渠道标题长度超过32个字符',
            'is_show.required'            => '显示状态不能为空',
            'is_show.integer'             => '显示状态格式不正确',
            'is_show.in'                  => '显示状态值不正确',
            'channel_group_uuid.required' => '渠道分组不能为空',
            'channel_group_uuid.uuid'     => '渠道分组格式不正确',
            'channel_group_uuid.exists'   => '渠道分组不存在',
            'file_uuid.uuid'              => '自定义推广码格式不正确',
            'file_uuid.exists'            => '自定义推广码不存在',
            'remark.max'                  => '渠道描述不能超过100个字符',
        ];
    }
}