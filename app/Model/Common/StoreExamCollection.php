<?php
declare(strict_types=1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\DbConnection\Db;

/**
 * 试卷
 *
 * Class StoreExamCollection
 * @package App\Model\Common
 */
class StoreExamCollection extends BaseModel
{
	protected $table = 'store_exam_collection';

	protected $fillable = [
		'uuid',
		'title',
		'is_show',
		'file_uuid',
		'orders',
		'store_uuid',
		'is_recommend',
		'submit_number',
		'exam_category_uuid',
		'exam_time',
		'content',
		'level',
		'author',
		'audit_author',
		"max_option_total",
		"max_judge_total",
		"max_reading_total",
		"resource_url",
	];

	protected $appends = [
		'use_time',// 试卷答题时间(s)
		'use_time_minutes', // 试卷答题时间(m)
		'option_sum', // 单选试题总数
		'reading_sum', // 简答试题总数
		"jude_sum", // 判断试题总题数
		"option_score", // 单选试题总分
		"jude_score", // 判断试题总分
		"reading_score", // 阅读理解总分
	];

	public function coverFileInfo(): BelongsTo
	{
		return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
	}

	public function collectionType(): BelongsTo
	{
		return $this->belongsTo(StoreExamCategory::class, 'exam_category_uuid', 'uuid');
	}

	public function examCategoryInfo(): BelongsTo
	{
		return $this->belongsTo(StoreExamCategory::class, 'exam_category_uuid', 'uuid');
	}

	public function getAuditAuthorAttribute($key): string
	{
		return empty($key) ? '' : $key;
	}

	public function getAuthorAttribute($key): string
	{
		return empty($key) ? '' : $key;
	}

	public function getContentAttribute($key): string
	{
		return empty($key) ? '' : $key;
	}

	public function getResourceUrlAttribute($key): string
	{
		return empty($key) ? '' : $key;
	}

	public function getUseTimeAttribute()
	{
		if (!empty($this->attributes['exam_time'])) {
			$examTime = explode(':', $this->attributes['exam_time']);
			return $examTime[0] * 3600 + $examTime[1] * 60 + ($examTime[2] > 0 ? 1 : 0);
		}

		return 0;
	}

	public function getUseTimeMinutesAttribute()
	{
		if (!empty($this->attributes['exam_time'])) {
			$examTime = explode(':', $this->attributes['exam_time']);
			return $examTime[0] * 60 + $examTime[1] + ($examTime[2] > 0 ? 1 : 0);
		}

		return 0;
	}

	public function getOptionSumAttribute(): int
	{
		return (new StoreExamCollectionRelation())::query()
			->where('exam_collection_uuid', '=', $this->attributes['uuid'])
			->count(['id']);
	}

	public function getReadingSumAttribute(): int
	{
		return (new StoreExamReadingCollectionRelation())::query()
			->where('collection_uuid', '=', $this->attributes['uuid'])
			->count(['id']);
	}

	public function getJudeSumAttribute(): int
	{
		return (new StoreExamJudeCollectionRelation())::query()
			->where('collection_uuid', '=', $this->attributes['uuid'])
			->count(['id']);
	}

	public function getOptionScoreAttribute()
	{
		$score = Db::table('store_exam_collection_relation')
			->join('store_exam_option', 'store_exam_collection_relation.exam_uuid', '=', 'store_exam_option.uuid')
			->where('store_exam_collection_relation.exam_collection_uuid', '=', $this->attributes['uuid'])
			->whereNull('store_exam_collection_relation.deleted_at')
			->whereNull('store_exam_option.deleted_at')
			->sum('answer_income_score');

		return empty($score) ? 0.00 : $score;
	}

	public function getReadingScoreAttribute()
	{
		$score = Db::table('store_exam_reading_collection_relation')
			->join('store_exam_reading', 'store_exam_reading_collection_relation.exam_uuid', '=', 'store_exam_reading.uuid')
			->where('store_exam_reading_collection_relation.collection_uuid', '=', $this->attributes['uuid'])
			->whereNull('store_exam_reading_collection_relation.deleted_at')
			->whereNull('store_exam_reading.deleted_at')
			->sum('answer_income_score');

		return empty($score) ? 0.00 : $score;
	}

	public function getJudeScoreAttribute()
	{
		$score = Db::table('store_exam_jude_collection_relation')
			->join('store_exam_judge_option', 'store_exam_jude_collection_relation.exam_uuid', '=', 'store_exam_judge_option.uuid')
			->where('store_exam_jude_collection_relation.collection_uuid', '=', $this->attributes['uuid'])
			->whereNull('store_exam_jude_collection_relation.deleted_at')
			->whereNull('store_exam_judge_option.deleted_at')
			->sum('answer_income_score');

		return empty($score) ? 0.00 : $score;
	}
}