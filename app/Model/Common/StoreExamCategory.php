<?php
declare(strict_types=1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 试题分类
 *
 * Class StoreExamCategory
 * @package App\Model\Common
 */
class StoreExamCategory extends BaseModel
{
	protected $table = 'store_exam_category';

	protected $fillable = [
		'uuid',
		'title',
		'parent_uuid',
		'remark',
		'is_show',
		'file_uuid',
		'big_file_uuid',
		'orders',
		'store_uuid',
		'is_recommend',
	];

	/**
	 * @return BelongsTo
	 */
	public function smallFileInfo()
	{
		return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
	}

	/**
	 * @return BelongsTo
	 */
	public function bigFileInfo()
	{
		return $this->belongsTo(StorePlatformFile::class, 'big_file_uuid', 'uuid');
	}
}