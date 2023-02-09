<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 文章关键词搜索
 */
class StoreArticleKeyWords extends BaseModel
{
    protected $table = "store_article_keywords";

    protected $fillable = [
        "uuid",
        "title",
        "is_show",
        "store_uuid",
        "create_id"
    ];

    /**
     * 创建人信息
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(StoreUser::class, "create_id", "id");
    }
}