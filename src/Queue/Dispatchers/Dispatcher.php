<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/14
 * Time: 下午2:47
 */

namespace XYLibrary\Queue\Dispatchers;


class Dispatcher
{
    public function __construct()
    {
    }

    /**
     * 分发
     * @param $job
     */
    public function dispatch($job){
        $manager = call_user_func(app('manager'));
        $queue = $manager->connection();
        $this->dispatchToQueue($job,$queue);
    }

    /**
     * 分发到队列
     * @param $job
     * @param $queue
     */
    public function dispatchToQueue($job,$queue){
        if(isset($job->delay)){//延迟任务
            $queue->laterOn($job->queue,$job->delay,$job);
        }else{
            $queue->pushOn($job->queue,$job);
        }
    }

}