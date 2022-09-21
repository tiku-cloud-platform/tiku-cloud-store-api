<?php
declare(strict_types=1);

namespace App\Service\Store\Config;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Config\PlatformSettingRepository;
use App\Service\StoreServiceInterface;
use Hyperf\Di\Annotation\Inject;
use RedisException;

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
	 * @throws RedisException
	 */
	public function serviceCreate(array $requestParams): bool
	{
		$requestParams['uuid']       = UUID::getUUID();
		$userInfo                    = UserInfo::getStoreUserInfo();
		$requestParams['store_uuid'] = $userInfo['store_uuid'];

		$this->settingRepository->repositoryCreate($requestParams);

		return $this->updateWxSetting((string)$userInfo['store_uuid'], $requestParams);
	}

	/**
	 * 更新数据.
	 *
	 * @param array $requestParams 请求参数
	 * @return int 更新行数
	 * @throws RedisException
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
	 * @throws RedisException
	 */
	private function updateWxSetting(string $storeUUID, array $cacheInfo): bool
	{
		if ($cacheInfo['type'] == 'wx_setting') {
			$valueArray = json_decode($cacheInfo["values"], true);
			unset($cacheInfo["values"]);
			$publicResult = RedisClient::create(CacheKey::STORE_PUBLICPROGRAM_SETTING, $storeUUID, [
				"name"       => $valueArray["offical_name"],
				"app_key"    => $valueArray["offical_app_key"],
				"app_secret" => $valueArray["offical_app_secret"],
			]);
			$miniResult   = RedisClient::create(CacheKey::STORE_MINIPROGRAM_SETTING, $storeUUID, [
				"name"       => $valueArray["name"],
				"app_key"    => $valueArray["app_key"],
				"app_secret" => $valueArray["app_secret"],
			]);

			if ($publicResult && $miniResult) return true;
			return false;
		}

		return true;
	}
}
