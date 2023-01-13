<?php
declare(strict_types = 1);

namespace App\Service\Store\Book;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Book\BookRepository;
use App\Service\StoreServiceInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 书籍基础信息
 * @package App\Service\Store\Book
 */
class BookService implements StoreServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
            if (!empty($title)) {
                $query->where('title', 'like', '%' . $title . '%');
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new BookRepository)->repositorySelect(
            self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20
        );
    }

    public function serviceCreate(array $requestParams): bool
    {
        $requestParams               = $this->formatter($requestParams);
        $requestParams["uuid"]       = UUID::getUUID();
        $requestParams['store_uuid'] = UserInfo::getStoreUserInfo()['store_uuid'];

        return (new BookRepository)->repositoryCreate($requestParams);
    }

    public function serviceUpdate(array $requestParams): int
    {
        if (!isset($requestParams["uuid"])) return 0;
        $requestParams = $this->formatter($requestParams);
        $uuid          = $requestParams["uuid"];
        unset($requestParams["uuid"]);

        return (new BookRepository)->repositoryUpdate([
            ['uuid', '=', $uuid],
        ], $requestParams);
    }

    public function serviceDelete(array $requestParams): int
    {
        $uuidArray   = explode(',', $requestParams['uuid']);
        $deleteWhere = [];
        foreach ($uuidArray as $value) {
            $deleteWhere[] = $value;
        }

        return (new BookRepository)->repositoryWhereInDelete($deleteWhere, 'uuid');
    }

    public function serviceFind(array $requestParams): array
    {
        return (new BookRepository)->repositoryFind(self::searchWhere($requestParams));
    }

    private function formatter(array $requestParams): array
    {
        $requestParams["tags"]   = !empty($requestParams["tags"]) ? str_replace("，", ",", $requestParams["tags"]) : "暂无标签";
        $requestParams["intro"]  = !empty($requestParams["intro"]) ? trim($requestParams["intro"]) : "暂无简介";
        $requestParams["title"]  = trim($requestParams["title"]);
        $requestParams["author"] = trim($requestParams["author"]);

        return $requestParams;
    }
}