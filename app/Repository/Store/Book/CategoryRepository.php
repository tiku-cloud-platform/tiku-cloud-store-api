<?php
declare(strict_types=1);

namespace App\Repository\Store\Book;

use App\Model\Store\StoreBookCategory;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 书籍目录
 * @package App\Repository\Store\Book
 */
class CategoryRepository implements StoreRepositoryInterface
{
	/**
	 * @Inject()
	 * @var StoreBookCategory
	 */
	protected $categoryModel;

	public function repositorySelect(Closure $closure, int $perSize): array
	{
		$items = $this->categoryModel::query()
			->with(["book:uuid,title"])
			->where($closure)
			->select([
				"uuid",
				"store_book_uuid",
				"title",
				"parent_uuid",
				"is_show",
				"orders",
				"created_at",
				"updated_at",
			])
			->orderByDesc('id')
			->paginate($perSize);

		return [
			'items' => $items->items(),
			'total' => $items->total(),
			'size'  => $items->perPage(),
			'page'  => $items->currentPage(),
		];
	}

	public function repositoryCreate(array $insertInfo): bool
	{
		if (!empty($this->categoryModel::query()->create($insertInfo))) {
			return true;
		}

		return false;
	}

	public function repositoryAdd(array $addInfo): int
	{
		return 0;
	}

	public function repositoryUpdate(array $updateWhere, array $updateInfo): int
	{
		return $this->categoryModel::query()->where($updateWhere)->update($updateInfo);
	}

	public function repositoryDelete(array $deleteWhere): int
	{
		return $this->categoryModel::query()->where($deleteWhere)->delete();
	}

	public function repositoryWhereInDelete(array $deleteWhere, string $field): int
	{
		return $this->categoryModel::query()->whereIn($field, $deleteWhere)->delete();
	}

	public function repositoryFind(\Closure $closure): array
	{
		$bean = $this->categoryModel::query()
			->with(["book:uuid,title"])
			->select([
				"uuid",
				"store_book_uuid",
				"title",
				"parent_uuid",
				"is_show",
				"orders",
				"created_at",
				"updated_at",
			])
			->where($closure)
			->first();

		if (!empty($bean)) {
			return $bean->toArray();
		}
		return [];
	}
}