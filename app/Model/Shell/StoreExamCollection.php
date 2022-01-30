<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 试卷
 * Class StoreExamCollection
 * @package App\Model\Shell
 */
class StoreExamCollection extends Model
{
    use SoftDeletes;

    protected $table = "store_exam_collection";
}