<?php
declare(strict_types=1);

namespace App\Model\Store;


use App\Constants\DataConfig;
use Hyperf\Database\Model\Relations\BelongsTo;
use function PHPStan\dumpType;

/**
 * 平台轮播图
 *
 * Class StoreBanner
 * @package App\Model\Store
 */
class StoreBanner extends \App\Model\Common\StoreBanner
{
	public $searchFields = [
		'uuid',
		'title',
		'file_uuid',
		'orders',
		'url',
		'position',
		'is_show',
		'type',
		'client_position',
	];

	protected $appends = [
		'client_position_remark'
	];

	protected $casts = [
		'position'        => 'string',
		'client_position' => 'string'
	];

	public function getClientPositionRemarkAttribute(): string
	{
		if (empty($this->getAttributes()['client_position'])) {
			return "";
		}
		return DataConfig::bannerClientType()[$this->getAttributes()['client_position']];
	}

	/**
	 * 显示位置
	 *
	 * @return BelongsTo
	 */
	public function positionShow(): BelongsTo
	{
		return $this->belongsTo(StorePlatformConstConfig::class, 'position', 'value')
			->where('title', '=', 'wechat_banner');
	}

	/**
	 * 跳转类型
	 *
	 * @return BelongsTo
	 */
	public function menuType(): BelongsTo
	{
		return $this->belongsTo(StorePlatformConstConfig::class, 'type', 'value')
			->where('title', '=', 'wechat_banner_navi');
	}
}