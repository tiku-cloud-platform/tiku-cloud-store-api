<?php
declare(strict_types = 1);

namespace App\Service\DashBoard;

use App\Mapping\UserInfo;
use Hyperf\DbConnection\Db;

/**
 * 会员数据指标统计
 */
class UserService
{
    /**
     * 会员数据指标
     * @return array
     */
    public function user(): array
    {
        /** @var string|false $currentDay 本月天数 */
        $currentDay = date("t", strtotime(date("Y-m-d")));

        /** @var int $incrementYesterday 昨日新增会员数 */
        $incrementYesterday = Db::table("store_platform_user")->where([
            ["store_uuid", "=", UserInfo::getStoreUserStoreUuid()]
        ])->whereBetween("created_at", [
            date("Y-m-d 00:00:00", strtotime("-1 day")),
            date("Y-m-d 23:59:59", strtotime("-1 day"))
        ])->count("id");

        /** @var int $incrementCurrentMonth 本月新增会员数 */
        $incrementCurrentMonth = Db::table("store_platform_user")->where([
            ["store_uuid", "=", UserInfo::getStoreUserStoreUuid()]
        ])->whereBetween("created_at", [
            date("Y-m-01 00:00:00"),
            date("Y-m-$currentDay 23:59:59")
        ])->count();

        return [
            "increment" => [// 会员新增指标
                "yesterday" => 2156,//$incrementYesterday,
                "current_month" => 35642,//$incrementCurrentMonth,
                "yesterday_circular_ratio" => 10.01,
                "current_month_circular_ratio" => 08.91,
            ],
            "visitor" => [// 会员访问指标
                "yesterday" => 198756,
                "current_month" => 569785,
                "yesterday_circular_ratio" => 12.00,
                "current_month_circular_ratio" => 8.00,
            ]
        ];
    }
}