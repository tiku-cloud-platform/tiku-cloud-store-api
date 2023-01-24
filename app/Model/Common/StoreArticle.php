<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 文章管理
 *
 * Class StoreArticle
 * @package App\Model\Common
 */
class StoreArticle extends BaseModel
{
    protected $table = 'store_article';

    protected $fillable = [
        'uuid',
        'article_category_uuid',
        'store_uuid',
        'title',
        'file_uuid',
        'content',
        'publish_date',
        'author',
        'source',
        'read_number',
        'orders',
        'is_show',
        'is_top',
        "read_score",
        "share_score",
        "click_score",
        "collection_score",
        "read_expend_score",
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
     * 文章封面
     * @return BelongsTo
     * @author kert
     */
    public function coverFileInfo(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }

    /**
     * 文章分类
     *
     * @return BelongsTo
     */
    public function categoryInfo()
    {
        return $this->belongsTo(StoreArticleCategory::class, 'article_category_uuid', 'uuid');
    }
}