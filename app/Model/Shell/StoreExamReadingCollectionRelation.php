<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 试卷阅读理解关联模型
 * Class StoreExamReadingCollectionRelation
 * @package App\Model\Shell
 */
class StoreExamReadingCollectionRelation extends Model
{
    use SoftDeletes;

    protected $table = "store_exam_reading_collection_relation";
}