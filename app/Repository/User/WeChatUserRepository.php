<?php
declare(strict_types = 1);

namespace App\Repository\User;

use App\Model\Store\StoreMiNiWeChatUser;
use App\Repository\StoreRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 微信小程序用户
 * Class WeChatUserRepository
 * @package App\Repository\Store\User
 */
class WeChatUserRepository implements StoreRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreMiNiWeChatUser
     */
    protected $userModel;

    /**
     * @inheritDoc
     */
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        $items = $this->userModel::query()
            ->with(["channel:uuid,title"])
            ->where($closure)
            ->select($this->userModel->listSearchFields)
            ->orderByDesc('id')
            ->paginate((int)$perSize);

        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size'  => $items->perPage(),
            'page'  => $items->currentPage(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        // TODO: Implement repositoryCreate() method.
    }

    /**
     * @inheritDoc
     */
    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    /**
     * @inheritDoc
     */
    public function repositoryFind(\Closure $closure): array
    {
        // TODO: Implement repositoryFind() method.
    }

    /**
     * @inheritDoc
     */
    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        // TODO: Implement repositoryUpdate() method.
    }

    /**
     * @inheritDoc
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        // TODO: Implement repositoryDelete() method.
    }

    /**
     * @inheritDoc
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        // TODO: Implement repositoryWhereInDelete() method.
    }
}