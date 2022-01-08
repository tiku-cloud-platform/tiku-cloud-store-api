<?php
declare(strict_types=1);

namespace App\Request\Api\Common;


use Hyperf\Validation\Request\FormRequest;

/**
 * 显示区域字段验证
 *
 * Class PositionValidate
 * @package App\Request\Api\Common
 */
class PositionValidate extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'position' => 'required',
		];
	}

	public function messages(): array
	{
		return [
			'position.required' => '参数缺少',
		];
	}
}