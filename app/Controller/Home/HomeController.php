<?php
declare(strict_types = 1);

namespace App\Controller\Home;

use App\Controller\StoreBaseController;
use App\Middleware\Auth\StoreAuthMiddleware;
use App\Service\Exam\CollectionService;
use App\Service\Exam\OptionService;
use App\Service\Exam\ReadingService;
use App\Service\Exam\SubmitHistoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 系统数据统计
 *
 * @Middlewares({
 *     @Middleware(StoreAuthMiddleware::class)
 *     })
 * @Controller(prefix="store/home")
 * Class HomeController
 * @deprecated
 * @package App\Controller\Store\User
 */
class HomeController extends StoreBaseController
{
    public function __construct(\App\Controller\Store\Home\UserService $userService)
    {
        parent::__construct($userService);
    }

    /**
     * @GetMapping(path="index")
     * @return ResponseInterface
     */
    public function index()
    {
        $userService          = new \App\Controller\Store\Home\UserService();
        $currentDayStartTime  = date('Y-m-d') . ' 00:00:00';
        $currentDayEndTime    = date('Y-m-d') . ' 23:59:59';
        $collectionService    = new CollectionService();
        $submitHistoryService = new SubmitHistoryService();
        $optionService        = new OptionService();
        $readinigService      = new ReadingService();

        $data = [
            'now_incr_number' => $userService->serviceCount((array)['start_time' => $currentDayStartTime, 'end_time' => $currentDayEndTime]),// 新增人数
            'register_number' => $userService->serviceCount(),// 注册人数
            'exam_number' => $optionService->serviceCount() + $readinigService->serviceCount(), // 试题总数
            'exam_submit_number' => $collectionService->serviceSum(), // 答题人数
            'register_people_number_list' => [
                'now_day' => [],
                'all' => [],
                'title' => '系统用户走势图'
            ],// 注册人数趋势
            'exam_submit_number_list' => [
                'now_day' => [],
                'all' => [],
                'title' => '系统答题走势图'
            ],// 总答题人数趋势
        ];

        /** @var array $monthStartAndEnd 当前月的开始月当前月的结束 */
        $monthStartAndEnd = [
            'start_time' => date('Y-m-01') . ' 00:00:00',
            'end_time' => date('Y-m-t') . ' 23:59:59'
        ];
        /** @var array $everyDayArray 每日用户注册 */
        $everyDayRegisterArray = $userService->serviceEveryDayRegister((array)$monthStartAndEnd);
        /** @var array $everDateTotal 每日用户总数 */
        $everDateTotalArray = $userService->serviceEveryDayTotal((array)$everyDayRegisterArray);
        /** @var array $everyDayExamArray 每日答题总数 */
        $everyDayExamArray = $submitHistoryService->serviceEveryDayRegister((array)$monthStartAndEnd);
        /** @var array $everyDayExamTotalArray 每日系统当前总数 */
        $everyDayExamTotalArray = $submitHistoryService->serviceEveryDayTotal((array)$everyDayExamArray);

        $data['register_people_number_list']['now_day'] = $everyDayRegisterArray;// 每日新增用户
        $data['register_people_number_list']['all']     = $everDateTotalArray;// 每日用户总数
        $data['exam_submit_number_list']['now_day']     = $everyDayExamArray;// 每日答题数量
        $data['exam_submit_number_list']['all']         = $everyDayExamTotalArray;// 每日答题总数

        return $this->httpResponse->success((array)$data);
    }
}