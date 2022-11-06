<?php
declare(strict_types=1);

namespace App\Request\Store\Exam;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 试题分类
 *
 * Class CategoryValidate
 * @package App\Request\Store\Exam
 */
class CollectionValidate extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'title'              => 'required|max:100',
			'is_show'            => ['required', Rule::in([1, 2])],
			'is_recommend'       => ['required', Rule::in([1, 2])],
			'file_uuid'          => 'sometimes|uuid|exists:store_platform_file,uuid',
			'orders'             => 'required|integer',
			'exam_category_uuid' => 'required|uuid|exists:store_exam_category,uuid',
			'exam_time'          => 'required|time',
			'level'              => 'required|integer',
			'max_judge_total'    => 'required|integer|max:10|min:1',
			'max_reading_total'  => 'required|integer|max:50|min:1',
			'max_option_total'   => 'required|integer|max:50|min:1',
			'resource_url'       => 'sometimes|max:255'
		];
	}

	public function messages(): array
	{
		return [
			'title.required'              => '名称不能为空',
			'title.max'                   => '名称不能超过100个字符',
			'is_show.required'            => '显示状态不能为空',
			'is_show.in'                  => '显示状态错误',
			'is_recommend.required'       => '推荐状态不能为空',
			'is_recommend.in'             => '推荐状态错误',
			'file_uuid.uuid'              => '封面格式不正确',
			'file_uuid.exists'            => '封面图片不存在',
			'orders.required'             => '显示顺序不能为空',
			'orders.integer'              => '显示顺序格式不正确',
			'exam_category_uuid.required' => '分类不能为空',
			'exam_category_uuid.uuid'     => '分类编号格式不正确',
			'exam_category_uuid.exist'    => '分类不存在',
			'exam_time.required'          => '作答时间不能为空',
			'exam_time.time'              => '答题时间格式不正确',
			'level.required'              => '试题难度不能为空',
			'level.integer'               => '试题难度格式不正确',
			"max_judge_total.required"    => "最大判断题数量不能为空",
			"max_judge_total.integer"     => "最大判断题数量格式不正确",
			"max_judge_total.max"         => "最大判断题数量不能超过10",
			"max_judge_total.min"         => "最大判断题数量不能小于1",
			"max_reading_total.required"  => "最大问答题数量不能为空",
			"max_reading_total.integer"   => "最大问答题数量格式不正确",
			"max_reading_total.max"       => "最大问答题数量不能超过50",
			"max_reading_total.min"       => "最大问答题数量不能小于1",
			"max_option_total.required"   => "最大选择题数量不能为空",
			"max_option_total.integer"    => "最大选择题数量格式不正确",
			"max_option_total.max"        => "最大选择题数量不能超过20",
			"max_option_total.min"        => "最大选择题数量不能小于1",
			"resource_url.max"            => "链接地址长度不能超过255"
		];
	}
}