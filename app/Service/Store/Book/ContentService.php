<?php
declare(strict_types=1);

namespace App\Service\Store\Book;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Store\Book\ContentRepository;
use App\Service\StoreServiceInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 书籍内容
 * @package App\Service\Store\Book
 */
class ContentService implements StoreServiceInterface
{
	/**
	 * @Inject()
	 * @var ContentRepository
	 */
	protected $contentRepository;

	public static function searchWhere(array $requestParams): Closure
	{
		return function ($query) use ($requestParams) {
			extract($requestParams);
			$query->where('store_book_uuid', '=', $store_book_uuid);
			if (!empty($uuid)) {
				$query->where('uuid', '=', $uuid);
			}
			if (!empty($store_book_category_uuid)) {
				$query->where('store_book_category_uuid', '=', $store_book_category_uuid);
			}
			if (!empty($title)) {
				$query->where('title', 'like', '%' . $title . '%');
			}
		};
	}

	public function serviceSelect(array $requestParams): array
	{
		return $this->contentRepository->repositorySelect(
			self::searchWhere($requestParams),
			(int)$requestParams['size'] ?? 20
		);
	}

	public function serviceCreate(array $requestParams): bool
	{
		$requestParams               = $this->formatter($requestParams);
		$requestParams["uuid"]       = UUID::getUUID();
		$requestParams['store_uuid'] = UserInfo::getStoreUserInfo()['store_uuid'];

		return $this->contentRepository->repositoryCreate($requestParams);
	}

	public function serviceUpdate(array $requestParams): int
	{
		if (!isset($requestParams["uuid"])) return 0;
		$requestParams = $this->formatter($requestParams);
		$uuid          = $requestParams["uuid"];
		unset($requestParams["uuid"]);

		return $this->contentRepository->repositoryUpdate([
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

		return $this->contentRepository->repositoryWhereInDelete($deleteWhere, 'uuid');
	}

	public function serviceFind(array $requestParams): array
	{
		return $this->contentRepository->repositoryFind(self::searchWhere($requestParams));
	}

	private function formatter(array $requestParams): array
	{
		$requestParams["tags"]         = str_replace("，", ",", $requestParams["tags"]);
		$requestParams["title"]        = trim($requestParams["title"]);
		$requestParams["author"]       = trim($requestParams["author"]);
		$requestParams["publish_time"] = date("Y-m-d H:i:s");

		return $requestParams;
	}
}