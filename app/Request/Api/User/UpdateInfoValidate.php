<?php
declare(strict_types=1);

namespace App\Request\Api\User;


use Hyperf\Validation\Request\FormRequest;

/**
 * 用户信息更新
 *
 * Class UpdateInfoValidate
 * @package App\Request\Api\User
 */
class UpdateInfoValidate extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules()
	{
		return [
			'real_name' => 'sometimes|max:10',
			'birthday'  => 'sometimes|date',
			'mobile'    => 'required|mobile',
			'province'  => 'nullable',
			'city'      => 'nullable',
			'district'  => 'nullable',
			'address'   => 'nullable',
			'longitude' => 'nullable',
			'latitude'  => 'nullable',
		];
	}

	public function messages(): array
	{
		return [
			'mobile.required' => '手机号不能为空',
		];
	}
}