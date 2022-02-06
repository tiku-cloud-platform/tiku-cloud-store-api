<?php
declare(strict_types = 1);

namespace App\Crontab;

use App\Mapping\RedisClient;
use App\Model\Shell\StoreExamCollection;
use App\Model\Shell\StoreExamReadingCollectionRelation;
use Hyperf\Crontab\Annotation\Crontab;

/**
 * 试卷答题人数队列
 * Class ExamReadingQueue
 * @package App\Crontab
 * @Crontab(name="exam_reading_queue", rule="*\/1 * * *  *", callback="execute", memo="试卷答题人数队列")
 */
class ExamReadingQueue
{
    public function execute()
    {
        $redis         = (new RedisClient())->redisClient;
        $redisPipeLine = $redis->pipeline();
        $redisPipeLine->lRange("reading:queue", 0, 20);
        $redisPipeLine->lTrim("reading:queue", 21, -1);

        $execResult = $redisPipeLine->exec();
        if (isset($execResult) && $execResult[1] === true) {
            /** @var array $uuidArray 试题uuid */
            $uuidArray = [];
            $cacheInfo = $execResult[0];
            foreach ($cacheInfo as $value) {
                $uuidArray[] = json_decode($value, true)["uuid"];
            }
            $res                      = 0;
            $collectionItemsUuidArray = [];
            if (count($uuidArray) > 0) {
                // 先查询出对应的试卷编号, 在更新试卷
                $uuidArray       = array_unique($uuidArray);
                $collectionItems = (new StoreExamReadingCollectionRelation())::query()->whereIn("exam_uuid", $uuidArray)->get(["collection_uuid"]);
                var_dump($collectionItems);
                foreach ($collectionItems as $value) {
                    array_push($collectionItemsUuidArray, $value->collection_uuid);
                }
                if (count($collectionItemsUuidArray) > 0) {
                    var_dump("试卷编号", $collectionItemsUuidArray);
                    $collectionItemsUuidArray = array_unique($collectionItemsUuidArray);
                    $res                      = (new StoreExamCollection())::query()->whereIn("uuid", $collectionItemsUuidArray)->increment("submit_number", 1);
                }
            }
            var_dump($res, $uuidArray, $collectionItemsUuidArray);
        }
    }
}