<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;

/**
 * 单选试题选项
 *
 * Class StoreExamOptionItem
 * @package App\Model\Common
 */
class StoreExamOptionItem extends BaseModel
{
    protected $table = 'store_exam_option_item';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'option_uuid',
        'title',
    ];
}