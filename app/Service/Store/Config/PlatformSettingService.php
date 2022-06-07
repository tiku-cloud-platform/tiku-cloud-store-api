<?php

declare(strict_types=1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Service\Store\Config;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Config\PlatformSettingRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台参数配置.
 *
 * Class PlatformSettingService
 */
class PlatformSettingService implements StoreServiceInterface
{
	/**
	 * @Inject
	 * @var PlatformSettingRepository
	 */
	protected $settingRepository;

	public function __construct()
	{
	}

	/**
	 * 格式化查询条件.
	 *
	 * @param array $requestParams 请求参数
	 * @return mixed 组装的查询条件
	 */
	public static function searchWhere(array $requestParams)
	{
		return function ($query) use ($requestParams) {
			extract($requestParams);
			if (!empty($uuid)) {
				$query->where('uuid', '=', $uuid);
			}
			if (!empty($type)) {
				$query->where('type', '=', $type);
			}
		};
	}

	/**
	 * 查询数据.
	 *
	 * @param array $requestParams 请求参数
	 * @return array 查询结果
	 */
	public function serviceSelect(array $requestParams): array
	{
		return $this->settingRepository->repositorySelect(
			self::searchWhere((array)$requestParams),
			(int)$requestParams['size'] ?? 20
		);
	}

	/**
	 * 创建数据.
	 *
	 * @param array $requestParams 请求参数
	 * @return bool true|false
	 */
	public function serviceCreate(array $requestParams): bool
	{
		$requestParams['uuid']       = UUID::getUUID();
		$userInfo                    = UserInfo::getStoreUserInfo();
		$requestParams['store_uuid'] = $userInfo['store_uuid'];

		$this->settingRepository->repositoryCreate($requestParams);

		return $this->updateWxSetting((string)$userInfo['store_uuid'], (array)$requestParams);
	}

	/**
	 * 更新数据.
	 *
	 * @param array $requestParams 请求参数
	 * @return int 更新行数
	 */
	public function serviceUpdate(array $requestParams): int
	{
		$this->settingRepository->repositoryUpdate([
			['uuid', '=', trim($requestParams['uuid'])],
		], [
			'title'  => trim($requestParams['title']),
			'type'   => trim($requestParams['type']),
			'values' => trim($requestParams['values']),
		]);

		if ($this->updateWxSetting((string)UserInfo::getStoreUserInfo()['store_uuid'], $requestParams)) {
			return 1;
		}

		return 0;
	}

	/**
	 * 删除数据.
	 *
	 * @param array $requestParams 请求参数
	 * @return int 删除行数
	 */
	public function serviceDelete(array $requestParams): int
	{
		$uuidArray   = explode(',', $requestParams['uuid']);
		$deleteWhere = [];
		foreach ($uuidArray as $value) {
			$deleteWhere[] = $value;
		}

		return $this->settingRepository->repositoryWhereInDelete($deleteWhere, 'uuid');
	}

	/**
	 * 查询单条数据.
	 *
	 * @param array $requestParams 请求参数
	 * @return array 删除行数
	 */
	public function serviceFind(array $requestParams): array
	{
		return $this->settingRepository->repositoryFind(self::searchWhere($requestParams));
	}

	/**
	 * 更新微信小程序配置信息
	 *
	 * @param string $storeUUID
	 * @param array $cacheInfo
	 * @return bool
	 */
	private function updateWxSetting(string $storeUUID, array $cacheInfo): bool
	{
		if ($cacheInfo['type'] == 'wx_setting') {
			$valueArray              = json_decode($cacheInfo["values"], true);
			$cacheInfo["name"]       = $valueArray["name"];
			$cacheInfo["app_key"]    = $valueArray["app_key"];
			$cacheInfo["app_secret"] = $valueArray["app_secret"];
			unset($cacheInfo["values"]);
			return RedisClient::create(CacheKey::STORE_PLATFORM_SETTING, $storeUUID, $cacheInfo);
		}

		return true;
	}
}
