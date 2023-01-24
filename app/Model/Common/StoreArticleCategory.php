<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 文章分类管理
 *
 * Class StoreArticleCategory
 * @package App\Model\Common
 */
class StoreArticleCategory extends BaseModel
{
    protected $table = 'store_article_category';

    protected $fillable = [
        'uuid',
        'parent_uuid',
        'store_uuid',
        'title',
        'cover',
        'orders',
        'is_show',
        'file_uuid',
        "create_id",
    ];

    protected $hidden = ["create_id"];

    /**
     * 创建人信息
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(StoreUser::class, "create_id", "id");
    }

    /**
     * 分类封面
     * @return BelongsTo
     * @author kert
     */
    public function coverFileInfo()
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }
}