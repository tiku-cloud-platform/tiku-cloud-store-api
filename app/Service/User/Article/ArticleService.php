<?php
declare(strict_types=1);

namespace App\Service\User\Article;

use App\Repository\User\Article\ArticleRepository;
use App\Service\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 文章
 *
 * Class ArticleService
 * @package App\Service\User\Article
 */
class ArticleService implements UserServiceInterface
{
	/**
	 * @Inject()
	 * @var ArticleRepository
	 */
	protected $articleRepository;

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
			if (!empty($uuid)) {
				$query->where('uuid', '=', $uuid);
			}
			if (!empty($article_category_uuid)) {
				$query->where('article_category_uuid', '=', $article_category_uuid);
			}
			if (!empty($is_top)) {
				$query->where('is_top', '=', 1);
			}
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
		return $this->articleRepository->repositorySelect(self::searchWhere((array)$requestParams),
			(int)$requestParams['size'] ?? 20);
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
	 * @return array
	 */
	public function serviceFind(array $requestParams): array
	{
		$bean = $this->articleRepository->repositoryFind(self::searchWhere((array)$requestParams));
		if (empty($bean['is_read'])) {
			$this->articleRepository->repositoryUpdateReadNumber((string)$requestParams['uuid']);
			(new ReadClickService())->serviceCreate((array)['article_uuid' => $requestParams['uuid'], 'type' => 2]);
		}

		return $bean;
	}

	/**
	 * 文章点赞
	 *
	 * @param array $requestParams
	 * @return int
	 */
	public function serviceClick(array $requestParams)
	{
		if ((new ReadClickService())->serviceCreate((array)['article_uuid' => $requestParams['uuid'], 'type' => 1])) {
			return $this->articleRepository->repositoryUpdateClickNumber((string)$requestParams['uuid']);
		}

		return 0;
	}
}