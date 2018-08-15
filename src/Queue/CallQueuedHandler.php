<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/15
 * Time: 下午6:27
 */

namespace XYLibrary\Queue;


use XYLibrary\Queue\Jobs\Job;

class CallQueuedHandler
{
    public function call(Job $job, $data){
        $instance = $instance = unserialize($data["command"]);;
        $instance->beforeJob();
        $instance->run();
        $instance->afterJob();

        //分发任务链下游任务
        $instance->dispatchChainJob();

        //执行成功删除
        $job->delete();
    }

}