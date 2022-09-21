<?php
declare(strict_types=1);

namespace App\Service\User\Platform;


use App\Constants\CacheKey;
use App\Constants\CacheTime;
use App\Mapping\RedisClient;
use App\Mapping\WeChatClient;
use App\Repository\User\Platform\SettingRepository;
use App\Service\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台参数配置
 *
 * Class SettingService
 * @package App\Service\User\Platform
 */
class SettingService implements UserServiceInterface
{
	/**
	 * @Inject()
	 * @var SettingRepository
	 */
	protected $settingRepository;

	public function __construct()
	{
	}

	/**
	 * 格式化查询条件
	 *
	 * @param array $requestParams 请求参数
	 * @return mixed 组装的查询条件
	 */
	public static function searchWhere(array $requestParams)
	{
		return function ($query) use ($requestParams) {
			extract($requestParams);
			if (!empty($type)) {
				return $query->where('type', '=', $type);
			}
		};
	}

	/**
	 * 查询数据
	 *
	 * @param array $requestParams 请求参数
	 * @return array 查询结果
	 */
	public function serviceSelect(array $requestParams): array
	{
		$storeUUId     = (new WeChatClient)->getUUIDHeader();
		$cacheSettInfo = RedisClient::get(CacheKey::STORE_MINIPROGRAM_SETTING, (string)$storeUUId);

		if (empty($cacheSettInfo)) {
			$items = $this->settingRepository->repositorySelect(self::searchWhere((array)$requestParams), (int)20000);

			$cacheSettInfo = $items['items'];

			RedisClient::create(CacheKey::STORE_MINIPROGRAM_SETTING,
				$storeUUId,
				(array)$cacheSettInfo,
				CacheTime::STORE_PLATFORM_SETTING_EXPIRE_TIME);
		}

		return $cacheSettInfo;
	}

	/**
	 * 创建数据
	 *
	 * @param array $requestParams 请求参数
	 * @return bool true|false
	 */
	public function serviceCreate(array $requestParams): bool
	{
	}

	/**
	 * 更新数据
	 *
	 * @param array $requestParams 请求参数
	 * @return int 更新行数
	 */
	public function serviceUpdate(array $requestParams): int
	{
	}

	/**
	 * 删除数据
	 *
	 * @param array $requestParams 请求参数
	 * @return int 删除行数
	 */
	public function serviceDelete(array $requestParams): int
	{
	}

	/**
	 * 查询单条数据
	 *
	 * @param array $requestParams 请求参数
	 * @return array 删除行数
	 */
	public function serviceFind(array $requestParams): array
	{
		$storeUUId     = (new WeChatClient)->getUUIDHeader();
		$cacheSettInfo = RedisClient::get(CacheKey::STORE_MINIPROGRAM_SETTING, (string)$storeUUId);

		if (empty($cacheSettInfo)) {
			$cacheSettInfo = $this->settingRepository->repositoryFind(self::searchWhere((array)$requestParams));
			RedisClient::create(CacheKey::STORE_MINIPROGRAM_SETTING,
				(string)$storeUUId,
				(array)$cacheSettInfo,
				(int)CacheTime::STORE_PLATFORM_SETTING_EXPIRE_TIME,);
		}

		return $cacheSettInfo;
	}
}