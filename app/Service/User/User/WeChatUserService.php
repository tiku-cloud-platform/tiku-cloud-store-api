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

namespace App\Service\User\User;

use App\Constants\CacheKey;
use App\Constants\CacheTime;
use App\Mapping\HttpRequest;
use App\Mapping\RedisClient;
use App\Mapping\SettingCache;
use App\Mapping\ThirdPlatformApi;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Mapping\WeChatClient;
use App\Repository\User\User\WeChatUserRepository;
use App\Service\UserServiceInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * 微信用户
 *
 * Class WeChatUserService
 */
class WeChatUserService implements UserServiceInterface
{
	/**
	 * @Inject()
	 * @var WeChatUserRepository
	 */
	protected $userRepository;

	/**
	 * @Inject()
	 * @var RequestInterface
	 */
	protected $request;

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
			if (!empty($openid)) {
				$query->where('openid', '=', $openid);
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
		return [];
	}

	/**
	 * 创建数据.
	 *
	 * @param array $requestParams 请求参数
	 * @return bool true|false
	 */
	public function serviceCreate(array $requestParams): bool
	{
		return false;
	}

	/**
	 * 更新数据.
	 *
	 * @param array $requestParams 请求参数
	 * @return int 更新行数
	 */
	public function serviceUpdate(array $requestParams): int
	{
		$userInfo                  = UserInfo::getWeChatUserInfo();
		$requestParams['birthday'] = empty($requestParams['birthday']) ? date('Y-m-d') : $requestParams['birthday'];

		$updateResult = $this->userRepository->repositoryUpdate((array)[
			['uuid', '=', $userInfo['uuid']],
			['store_uuid', '=', $userInfo['store_uuid']]
		], (array)$requestParams);

		if ($updateResult) {
			// 更新缓存信息
			$userInfo['real_name'] = $requestParams['real_name'];
			$userInfo['longitude'] = $requestParams['longitude'];
			$userInfo['latitude']  = $requestParams['latitude'];
			$userInfo['district']  = $requestParams['district'];
			$userInfo['birthday']  = $requestParams['birthday'];
			$userInfo['province']  = $requestParams['province'];
			$userInfo['city']      = $requestParams['city'];
			$userInfo['address']   = $requestParams['address'];
			$userInfo['mobile']    = $requestParams['mobile'];
			if (RedisClient::update((string)CacheKey::USER_LOGIN_PREFIX,
				(string)(new UserInfo())->getWeChatLoginToken(),
				(array)$userInfo,
				(int)CacheTime::USER_LOGIN_EXPIRE_TIME
			)) {
				return 1;
			}
			return 0;
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
		return 0;
	}

	/**
	 * 查询单条数据.
	 *
	 * @param array $requestParams 请求参数
	 * @return array 删除行数
	 */
	public function serviceFind(array $requestParams): array
	{
		$userCacheInfo = UserInfo::getWeChatUserInfo();
		$userInfo      = [
			'sign'           => [
				'is_sign'   => 0,
				'sign_days' => 0,
			],
			'collection'     => 0,
			'attention'      => 0,
			'score'          => 0,
			'unread_message' => 0,
			'userInfo'       => $userCacheInfo,
			'favorites'      => 0,
		];
		if (empty($userCacheInfo)) {
			return $userInfo;
		}

		switch ($userCacheInfo['gender']) {
			case 1:
				$userCacheInfo['gender'] = '男';
				break;
			case 2:
				$userCacheInfo['gender'] = '女';
				break;
			default:
				$userCacheInfo['gender'] = '未知';
		}

		// 答卷情况
		$userInfo['collection'] = (new ExamSubmitHistoryService())->serviceSubmitCount((array)[
			'user_uuid' => $userCacheInfo['user_uuid']
		]);

		// 签到情况
		$userSignCollection = (new SignCollectionService())->serviceFind((array)['user_uuid' => $userCacheInfo['user_uuid']]);
		$userSignHistory    = (new SignHistoryService())->serviceFind((array)['user_uuid' => $userCacheInfo['user_uuid'], 'sign_date' => date('Y-m-d')]);

		// 登录状态
		$userInfo['sign']           = [
			'is_sign'   => empty($userSignHistory) ? 0 : 1,
			'sign_days' => empty($userSignCollection) ? 0 : $userSignCollection['sign_number'],
		];
		$userInfo['score']          = (new ScoreHistoryService())->scoreCount((string)$userCacheInfo['user_uuid']);
		$userInfo['unread_message'] = (new MessageHistoryService())->serviceCount((array)['user_uuid' => $userCacheInfo['user_uuid']]);

		return $userInfo;
	}

	/**
	 * 微信端用户登录[code和userInfo一并传入登录]
	 *
	 * @param array $requestParams
	 * @return array
	 */
	public function serviceWeChatLogin(array $requestParams): array
	{
		$settingInfo = SettingCache::getSetting((string)'wx_setting');
		$returnData  = ['code' => 0, 'message' => '请求成功', 'data' => ['token' => '', 'nickname' => '']];

		if (!empty($settingInfo)) {
			$url  = ThirdPlatformApi::WX_MINI_LOGIN_URL . "appid={$settingInfo['values']['app_key']}&secret={$settingInfo['values']['app_secret']}&js_code={$requestParams['code']}&grant_type=authorization_code";
			$info = (new HttpRequest())->getRequest((string)$url);

			try {
				if ($info['code'] == 0 && !isset($info['data']['errcode'])) {
					$loginToken = md5((string)$info['data']['openid'] . mt_rand(1000, 99999));

					$miniUserInfo = $this->userRepository->repositoryFind(self::searchWhere((array)['openid' => $info['data']['openid']]));
					// 查询对应的商户平台设置的默认用户分组
					$userGroup = (new StorePlatformUserGroupService())->serviceFind((array)['is_default' => 1]);

					if (!empty($miniUserInfo)) {// 更新用户
						$result = $this->userRepository->repositoryUpdate((array)[
							['openid', '=', $miniUserInfo['openid']],
							['store_uuid', '=', (new WeChatClient())->getUUIDHeader()]
						], (array)[
							'nickname'   => $requestParams['userInfo']['nickName'],
							'avatar_url' => $requestParams['userInfo']['avatarUrl'],
							'gender'     => $requestParams['userInfo']['gender'],
							'country'    => $requestParams['userInfo']['country'],
							'province'   => $requestParams['userInfo']['province'],
							'city'       => $requestParams['userInfo']['city'],
							'language'   => $requestParams['userInfo']['language'],
						]);
						(new StorePlatformUserService)->serviceUpdate((array)[
							'login_token'                    => $loginToken,
							'uuid'                           => $miniUserInfo['user']['uuid'],
							'store_platform_user_group_uuid' => $userGroup['uuid']
						]);
						RedisClient::delete((string)CacheKey::USER_LOGIN_PREFIX, (string)$miniUserInfo['user']['login_token']);
					} else {// 创建用户
						$userId     = UUID::getUUID();
						$wechatUuid = UUID::getUUID();
						$storeUuid  = (new WeChatClient())->getUUIDHeader();
						$userInfo   = $miniUserInfo = [
							'uuid'         => $wechatUuid,
							'openid'       => $info['data']['openid'],
							'nickname'     => $requestParams['userInfo']['nickName'],
							'avatar_url'   => $requestParams['userInfo']['avatarUrl'],
							'gender'       => $requestParams['userInfo']['gender'],
							'country'      => $requestParams['userInfo']['country'],
							'province'     => $requestParams['userInfo']['province'],
							'city'         => $requestParams['userInfo']['city'],
							'is_forbidden' => 1,
							'language'     => $requestParams['userInfo']['language'],
							'real_name'    => '',// 特殊参数就给一个默认空，避免小程序端用户登录之后，在个人中心会看到null相关的信息。
							'mobile'       => '',
							'address'      => '',
							'longitude'    => null,
							'latitude'     => null,
							'district'     => null,
							'birthday'     => null,
							'store_uuid'   => $storeUuid,
						];

						$result                    = false;
						$userInfo['uuid']          = $userId;
						$userInfo['login_token']   = $loginToken;
						$miniUserInfo['user_uuid'] = $userId;
						if (count($userGroup) > 0) {
							$userInfo['store_platform_user_group_uuid'] = $userGroup['uuid'];
						}
						Db::transaction(function () use ($miniUserInfo, $userInfo, $wechatUuid, &$result, $userId) {
							// 1. 给用户创建主账号
							(new StorePlatformUserService())->serviceCreate((array)$userInfo);
							// 2. 给用户创建微信小程序账号
							$result = $this->userRepository->repositoryCreate((array)$miniUserInfo);
							// 新用户注册送积分
							(new ScoreHistoryService())->serviceCreate((array)[
								'scene' => 'wechat_register',
								'data'  => [
									'type'      => 1,
									'user_uuid' => $userId,
								]
							]);
							$result = true;
						});
						$miniUserInfo['created_at'] = date('Y-m-d H:i:s');
					}
					if ($result) {
						//$userInfo['user_agent'] = $this->request->header('User-Agent', null);
						// 生成Redis缓存信息
						RedisClient::create((string)CacheKey::USER_LOGIN_PREFIX, (string)$loginToken, (array)$miniUserInfo, (int)CacheTime::USER_LOGIN_EXPIRE_TIME);
						$returnData['data']['token']     = $loginToken;
						$returnData['data']['nickName']  = $requestParams['userInfo']['nickName'];
						$returnData['data']['avatarUrl'] = $requestParams['userInfo']['avatarUrl'];
					}
				} else {
					$returnData['code']    = 1;
					$returnData['message'] = $info['msg'];
				}
			} catch (\Exception $exception) {
				var_dump($exception->getMessage());
				$returnData['code']    = 1;
				$returnData['message'] = '微信授权失败';
			}
		} else {
			$returnData['code']    = 1;
			$returnData['message'] = '小程序不存在';
		}

		return $returnData;
	}

	/**
	 * 微信小程序静默授权
	 *
	 * @param array $requestParams
	 * @return array
	 * @deprecated
	 */
	public function serviceQuiteWeChatLogin(array $requestParams): array
	{
		$settingInfo = SettingCache::getSetting((string)'wx_setting');
		$returnData  = ['code' => 0, 'message' => '请求成功', 'data' => ['token' => '', 'nickname' => '']];

		if (!empty($settingInfo)) {
			$url  = ThirdPlatformApi::WX_MINI_LOGIN_URL . "appid={$settingInfo['values']['app_key']}&secret={$settingInfo['values']['app_secret']}&js_code={$requestParams['code']}&grant_type=authorization_code";
			$info = (new HttpRequest())->getRequest((string)$url);

			try {
				if ($info['code'] == 0 && !isset($info['data']['errcode'])) {
					$loginToken = md5((string)$info['data']['openid'] . mt_rand(1000, 99999));

					$userInfo = $this->userRepository->repositoryFind(self::searchWhere((array)['openid' => $info['data']['openid']]));
					if ($userInfo) {
						RedisClient::delete((string)CacheKey::USER_LOGIN_PREFIX, (string)$userInfo['user']['login_token']);
						RedisClient::create((string)CacheKey::USER_LOGIN_PREFIX, (string)$loginToken, (array)$userInfo, (int)CacheTime::USER_LOGIN_EXPIRE_TIME);
						$returnData['data']['token']     = $loginToken;
						$returnData['data']['nickName']  = $requestParams['userInfo']['nickName'];
						$returnData['data']['avatarUrl'] = $requestParams['userInfo']['avatarUrl'];
					} else {
						$returnData['code']    = 3;// 只要用户未注册的情况下，才返回code=3。
						$returnData['message'] = '该用户还未注册';
					}
				} else {
					$returnData['code']    = 1;
					$returnData['message'] = $info['msg'];
				}
			} catch (\Exception $exception) {
				$returnData['code']    = 1;
				$returnData['message'] = '登录异常';
			}
		} else {
			$returnData['code']    = 1;
			$returnData['message'] = '小程序不存在';
		}

		return $returnData;
	}
}
