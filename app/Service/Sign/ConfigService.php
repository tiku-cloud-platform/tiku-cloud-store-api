<?php
declare(strict_types = 1);

namespace App\Service\Sign;

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

        return (new ConfigRepository)->repositoryCreate($requestParams);
    }

    public function serviceUpdate(array $requestParams): int
    {
        $uuid = $requestParams["uuid"];
        unset($requestParams["uuid"]);
        return (new ConfigRepository)->repositoryUpdate([
            ['uuid', '=', $uuid],
        ], $requestParams);
    }

    public function serviceDelete(array $requestParams): int
    {
        $uuidArray   = explode(',', $requestParams['uuid']);
        $deleteWhere = [];
        foreach ($uuidArray as $value) {
            array_push($deleteWhere, $value);
        }
        return (new ConfigRepository())->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    public function serviceFind(array $requestParams): array
    {
        return (new ConfigRepository)->repositoryFind(self::searchWhere($requestParams));
    }
}