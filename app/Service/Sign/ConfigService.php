<?php
declare(strict_types = 1);

namespace App\Service\Sign;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Sign\ConfigRepository;
use App\Service\StoreServiceInterface;

/**
 * 签到配置
 */
class ConfigService implements StoreServiceInterface
{

    public static function searchWhere(array $requestParams)
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
            if (!empty($is_show)) {
                $query->where('is_show', '=', $is_show);
            }
            if (!empty($is_continue)) {
                $query->where('is_continue', '=', $is_continue);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new ConfigRepository)->repositorySelect(
            self::searchWhere($requestParams),
            (int)($requestParams['size'] ?? 20)
        );
    }

    public function serviceCreate(array $requestParams): bool
    {
        $requestParams['uuid']       = UUID::getUUID();
        $requestParams['store_uuid'] = UserInfo::getStoreUserInfo()['store_uuid'];
        if ((new ConfigRepository)->repositoryCreate($requestParams) && $requestParams["is_show"] === 1) {
            $updateResult = RedisClient::getInstance()->hSet(CacheKey::SIGN_CONFIG . UserInfo::getStoreUserInfo()["store_uuid"],
                (string)$requestParams["num"], json_encode([
                    "score" => $requestParams["score"],
                    "is_continue" => $requestParams["is_continue"],
                ], JSON_UNESCAPED_UNICODE));
            if ($updateResult === 1 || $updateResult === 0) {
                return true;
            }
        }
        return false;
    }

    public function serviceUpdate(array $requestParams): int
    {
        $uuid = $requestParams["uuid"];
        unset($requestParams["uuid"], $requestParams["creator"]);
        if ((new ConfigRepository)->repositoryUpdate([['uuid', '=', $uuid]], $requestParams)) {
            if ($requestParams["is_show"] === 1) {
                $updateResult = RedisClient::getInstance()->hSet(CacheKey::SIGN_CONFIG . UserInfo::getStoreUserInfo()["store_uuid"],
                    (string)$requestParams["num"], json_encode([
                        "score" => $requestParams["score"],
                        "is_continue" => $requestParams["is_continue"],
                    ], JSON_UNESCAPED_UNICODE));
                if ($updateResult === 1 || $updateResult === 0) {
                    return 1;
                }
            } else {
                $updateResult = RedisClient::getInstance()->hSet(CacheKey::SIGN_CONFIG . UserInfo::getStoreUserInfo()["store_uuid"],
                    (string)$requestParams["num"], json_encode([
                        "score" => 0.00,
                        "is_continue" => 0,
                    ], JSON_UNESCAPED_UNICODE));
                if ($updateResult === 1 || $updateResult === 0) {
                    return 1;
                }
            }
        }
        return 0;
    }

    public function serviceDelete(array $requestParams): int
    {
        $uuidArray   = explode(',', $requestParams['uuid']);
        $deleteWhere = [];
        foreach ($uuidArray as $value) {
            array_push($deleteWhere, $value);
        }
        $configRepository = new ConfigRepository();
        $configList       = $configRepository->repositoryAll(function ($query) use ($deleteWhere) {
            $query->whereIn("uuid", $deleteWhere);
        }, ["num", "score"]);
        if ($configRepository->repositoryWhereInDelete($deleteWhere, 'uuid')) {
            // 将删除的天数设置为0
            foreach ($configList as $value) {
                $scoreConfig = [
                    $value->num => json_encode([
                        "score" => 0.00,
                        "is_continue" => 0,
                    ], JSON_UNESCAPED_UNICODE),
                ];
            }
            if (count($scoreConfig) > 0) {
                if (RedisClient::getInstance()->hMSet(CacheKey::SIGN_CONFIG . UserInfo::getStoreUserInfo()["store_uuid"], $scoreConfig)) {
                    return 1;
                }
            }
        }
        return 0;
    }

    public function serviceFind(array $requestParams): array
    {
        return (new ConfigRepository)->repositoryFind(self::searchWhere($requestParams));
    }
}