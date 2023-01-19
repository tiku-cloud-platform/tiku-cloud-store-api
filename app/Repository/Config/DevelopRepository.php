<?php
declare(strict_types = 1);

namespace App\Repository\Config;

use App\Model\Store\StoreDevelopConfig;
use App\Repository\StoreRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 商户开发配置
 */
class DevelopRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreDevelopConfig
     */
    protected $configModel;

    public function repositorySelect(Closure $closure, int $perSize): array
    {
        // TODO: Implement repositorySelect() method.
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        // TODO: Implement repositoryCreate() method.
    }

    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    /**
     * 商户开发配置
     * @param Closure $closure
     * @return array
     */
    public function repositoryFind(Closure $closure): array
    {
        $bean = $this->configModel::query()->where($closure)->first(["appid", "app_secret"]);
        if (!empty($bean)) {
            return $bean->toArray();
        }
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        // TODO: Implement repositoryUpdate() method.
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        // TODO: Implement repositoryDelete() method.
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        // TODO: Implement repositoryWhereInDelete() method.
    }
}