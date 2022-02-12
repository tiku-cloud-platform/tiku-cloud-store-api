<?php
declare(strict_types = 1);

namespace App\Model\Store;

/**
 * 平台文件管理
 *
 * Class StorePlatformFile
 * @package App\Model\Store
 */
class StorePlatformFile extends \App\Model\Common\StorePlatformFile
{
    public $searchFields = [
        'uuid',
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