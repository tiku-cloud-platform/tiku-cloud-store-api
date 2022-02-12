<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;

/**
 * 平台文件
 *
 * Class StorePlatformFile
 * @package App\Model\Common
 */
class StorePlatformFile extends BaseModel
{
    protected $table = 'store_platform_file';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'storage',
        'file_url',
        'file_name',
        'file_hash',
        'file_size',
        'file_type',
        'extension',
        'is_show'
    ];
}