<?php
declare(strict_types = 1);

namespace App\Service\Config;

use App\Constants\CacheKey;
use App\Library\Encrypt\AesEncrypt;
use App\Mapping\RedisClient;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Config\PlatformSettingRepository;
use App\Service\StoreServiceInterface;
use RedisException;

/**
 * 平台参数配置
 * Class PlatformSettingService
 */
class PlatformSettingService implements StoreServiceInterface
{
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
        return (new PlatformSettingRepository)->repositorySelect(
            self::searchWhere($requestParams),
            (int)($requestParams['size'] ?? 20)
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
        if ($requestParams["type"] == "wx_setting") {
            $value                   = json_decode($requestParams["values"], true);
            $value["mini_secret"]    = $this->configEncrypt([
                "client" => "wechat_miniprogram",
                "app_key" => trim($value["app_key"]),
                "app_secret" => trim($value["app_secret"]),
                "store_uuid" => $userInfo["store_uuid"],
            ]);
            $value["office_secret"]  = $this->configEncrypt([
                "client" => "office",
                "app_key" => trim($value["offical_app_key"]),
                "app_secret" => trim($value["offical_app_secret"]),
                "store_uuid" => $userInfo["store_uuid"],
            ]);
            $requestParams["values"] = json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        (new PlatformSettingRepository)->repositoryCreate($requestParams);

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
        unset($requestParams["creator"]);
        if ($requestParams["type"] == "wx_setting") {
            $value                   = json_decode($requestParams["values"], true);
            $value["mini_secret"]    = $this->configEncrypt([
                "client" => "wechat_miniprogram",
                "app_key" => trim($value["app_key"]),
                "app_secret" => trim($value["app_secret"]),
                "store_uuid" => UserInfo::getStoreUserStoreUuid(),
            ]);
            $value["office_secret"]  = $this->configEncrypt([
                "client" => "office",
                "app_key" => trim($value["offical_app_key"]),
                "app_secret" => trim($value["offical_app_secret"]),
                "store_uuid" => UserInfo::getStoreUserStoreUuid(),
            ]);
            $requestParams["values"] = json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        (new PlatformSettingRepository)->repositoryUpdate([
            ['uuid', '=', trim($requestParams['uuid'])],
        ], [
            'title' => trim($requestParams['title']),
            'type' => trim($requestParams['type']),
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

        return (new PlatformSettingRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    /**
     * 查询单条数据.
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        return (new PlatformSettingRepository)->repositoryFind(self::searchWhere($requestParams));
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
            // 微信公众号配置
            $publicResult = RedisClient::getInstance()->hMSet(CacheKey::STORE_OFFICE_SETTING . $storeUUID, [
                "name" => $valueArray["offical_name"] ?? "",
                "app_key" => $valueArray["offical_app_key"] ?? "",
                "app_secret" => $valueArray["offical_app_secret"] ?? ""
            ]);
            // 微信小程序配置
            $miniResult = RedisClient::getInstance()->hMSet(CacheKey::STORE_MINI_SETTING . $storeUUID, [
                "name" => $valueArray["name"],
                "app_key" => $valueArray["app_key"],
                "app_secret" => $valueArray["app_secret"],
            ]);
            // 商户开发配置
            $bean            = (new DevelopService())->serviceFind([
                "store_uuid" => $storeUUID,
            ]);
            $devConfigResult = RedisClient::getInstance()->hMSet(CacheKey::STORE_DEVEL_CONFIG . $storeUUID, [
                "uuid" => $storeUUID,
                "appid" => $bean["appid"],
            ]);
            if ($publicResult && $miniResult && $devConfigResult) return true;
            return false;
        }
        return true;
    }

    /**
     * 加密微信开发参数
     * @param array $secret
     * @return string
     */
    private function configEncrypt(array $secret): string
    {
        // 商户开发配置
        $bean            = (new DevelopService())->serviceFind([
            "store_uuid" => $secret["store_uuid"],
        ]);
        $secret["appid"] = $bean["appid"];
        $values          = json_encode($secret, JSON_UNESCAPED_UNICODE);
        return AesEncrypt::getInstance()->aesEncrypt($values);
    }
}
