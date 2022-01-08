<?php
declare(strict_types=1);

namespace App\Service\User\Article;


use App\Repository\User\Article\CategoryRepository;
use App\Service\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 文章分类
 *
 * Class CategoryService
 * @package App\Service\User\Article]
 */
class CategoryService implements UserServiceInterface
{
	/**
	 * @Inject()
	 * @var CategoryRepository
	 */
	protected $categoryRepository;

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
			$query->where('uuid', '<>', '');
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
		// TODO 二级分类的场景待考虑
		$items = $this->categoryRepository->repositorySelect(self::searchWhere((array)$requestParams),
			(int)$requestParams['size'] ?? 20);
        if (!empty($items["items"])) {
            array_unshift($items['items'], [
                'cover_file_info' => null,
                'file_uuid'       => null,
                'parent_uuid'     => null,
                'title'           => "全部",
                'uuid'            => ""
            ]);
        }
		return $items;
	}

	/**
	 * 创建数据
	 *
	 * @param array $requestParams 请求参数
	 * @return bool true|false
	 */
	public function serviceCreate(array $requestParams): bool
	{
		// TODO: Implement serviceCreate() method.
	}

	/**
	 * 更新数据
	 *
	 * @param array $requestParams 请求参数
	 * @return int 更新行数
	 */
	public function serviceUpdate(array $requestParams): int
	{
		// TODO: Implement serviceUpdate() method.
	}

	/**
	 * 删除数据
	 *
	 * @param array $requestParams 请求参数
	 * @return int 删除行数
	 */
	public function serviceDelete(array $requestParams): int
	{
		// TODO: Implement serviceDelete() method.
	}

	/**
	 * 查询单条数据
	 *
	 * @param array $requestParams 请求参数
	 * @return array 删除行数
	 */
	public function serviceFind(array $requestParams): array
	{
		// TODO: Implement serviceFind() method.
	}
}