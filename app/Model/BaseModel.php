<?php
declare(strict_types=1);

namespace App\Model;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Scopes\ClientScope;
use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Db;
use Hyperf\DbConnection\Model\Model;

/**
 * 基础模型
 *
 * Class BaseModel
 * @package App\Model
 */
class BaseModel extends Model
{
    use SoftDeletes;

    protected function boot(): void
    {
        parent::boot();

        static::addGlobalScope(new ClientScope());
    }

    /**
     * 数据批量插入
     *
     * @param string $tableName 数据表
     * @param array $insertInfo 插入数据[['字段名称1' => '字段值1', '字段名称2' => '字段值2']]
     * @param string $relationKeyName 外键关联的字段名
     * @param string $relationUUID 关键管理字段名对应的值
     * @param string $type 商户端还是用户端
     * @return bool
     */
    public function batchInsert(string $tableName, array $insertInfo, string $relationKeyName = '', string $relationUUID = '', string $type = 'store'): bool
    {
        $userInfo = UserInfo::getStoreUserInfo();
        $datetime = date('Y-m-d H:i:s');
        foreach ($insertInfo as $key => $value) {
            $insertInfo[$key]['created_at'] = $datetime;
            $insertInfo[$key]['updated_at'] = $datetime;
            $insertInfo[$key]['is_show']    = 1;
            $insertInfo[$key]['uuid']       = UUID::getUUID();
            if ($type == 'store') {
                $insertInfo[$key]['store_uuid'] = $userInfo['store_uuid'];
            }
            if (!empty($relationUUID)) {
                $insertInfo[$key][$relationKeyName] = $relationUUID;
            }
        }

        if (Db::table($tableName)->insert($insertInfo)) return true;
        return false;
    }

    /**
     * 数据批量更新
     *
     * @param string $tableName 数据表
     * @param array $updateInfo 更新数据[['字段名称1' => '字段值1', '字段名称2' => '字段值2']]
     * @param string $relationKeyName 外键关联的字段名
     * @param string $relationUUID 关键管理字段名对应的值
     * @return bool
     */
    public function batchUpdateOrCreate(string $tableName, array $updateInfo, string $relationKeyName = '', string $relationUUID = ''): bool
    {
        $createInfoArray = [];
        $updateInfoArray = [];
        foreach ($updateInfo as $key => $value) {
            if (empty($value['uuid'])) {
                $createInfoArray[$key] = $value;
            } else {
                $updateInfoArray[$key] = $value;
            }
        }

        $insertResult = $this->batchInsert((string)$tableName, (array)$createInfoArray, (string)$relationKeyName, (string)$relationUUID);
        $updateRows   = $this->batchUpdate((string)$tableName, (array)$updateInfoArray, (string)"uuid");
        if ((count($createInfoArray) > 0 && $insertResult) || (count($createInfoArray) < 1)) {
            return true;
        }
        return false;
    }

    /**
     * 数据批量更新
     *
     * @param string $tableName 数据表
     * @param array $updateInfo 插入数据[['字段名称1' => '字段值1', '字段名称2' => '字段值2']]
     * @param string $updateKey 更新主键名称
     * @return int
     */
    public function batchUpdate(string $tableName, array $updateInfo, string $updateKey): int
    {
        $rows = 0;
        foreach ($updateInfo as $key => $value) {
            if (isset($value[$updateKey])) {
                $value["updated_at"] = date('Y-m-d H:i:s');
                if (Db::table($tableName)->where($updateKey, "=", $value[$updateKey])->update($value)) {
                    ++$rows;
                }
            }
        }
        return $rows;
    }

    /**
     * 使用case column when x then x进行批量更新
     *
     * @param string $tableName 更新数据表
     * @param array $updateField 更新字段["字段名1", "字段名2", "字段名3"]
     * @param array $updateInfo 更新信息[["id" => "值", "字段名" => "字段值"]]
     * @return int 更新的行数
     */
    public function batchUpdateWhere(string $tableName, array $updateField = [], array $updateInfo = []): int
    {
        if (count($updateInfo) < 1) return 0;
        $str             = " update {$tableName} set ";
        $combineStrArray = [];
        try {
            foreach ($updateField as $k => $v) {
                $s = " $v =  (case id  ";
                foreach ($updateInfo as $key => $value) {
                    $s .= " when '{$value['id']}' then '$value[$v]' ";
                }
                $s                   .= " end)";
                $combineStrArray[$k] = $s;
            }

            $combineStr = implode(",", $combineStrArray);
            $fullStr    = $str . $combineStr;
            $idArray    = array_column($updateInfo, 'id');
            $idStr      = implode(',', $idArray);
            $sqlQuery   = $fullStr . " where id in ($idStr)";
            var_dump($sqlQuery);

            if (Db::select($sqlQuery)) return count($updateInfo);
            return 0;
        } catch (\Throwable $throwable) {
            // TODO 记录异常日志
            return 0;
        }
    }

    /**
     * 字段值增加
     *
     * @param string $tableName 数据表
     * @param array $updateWhere 更新条件
     * @param string $incrField 更新字段
     * @param int $incrVal 步长
     * @return int
     * @author kert
     */
    public function fieldIncr(string $tableName, array $updateWhere, string $incrField, int $incrVal): int
    {
        return Db::table($tableName)->where($updateWhere)->update([
            $incrField   => Db::raw("$incrField + $incrVal"),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * 字段值减少
     *
     * @param string $tableName 数据表
     * @param array $updateWhere 更新条件
     * @param string $decrField 更新字段
     * @param int $decrVal 步长
     * @return int
     * @author kert
     */
    public function fieldDecr(string $tableName, array $updateWhere, string $decrField, int $decrVal): int
    {
        return Db::table($tableName)->where($updateWhere)->update([
            $decrField   => Db::raw("$decrField - $decrVal"),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
