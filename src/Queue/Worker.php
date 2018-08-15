<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/13
 * Time: 下午4:41
 */

namespace XYLibrary\Queue;


use XYLibrary\Queue\Jobs\Job;

class Worker
{
    /**
     * 守护方法
     * @param WorkerOptions $options
     */
    public function daemon(WorkerOptions $options){
        $queues = $options->queues;
        $job = $this->getNextJob($queues);
        $this->runJob($job, $options);
    }

    /**
     * 获取下一个任务
     * @param $queues
     */
    public function getNextJob($queues){
        $connection = call_user_func(app('manager'))->connection();
        $queues = explode(',',$queues);
        foreach($queues as $queue){
            return $connection->pop($queue);
        }

    }

    public function runJob(Job $job,WorkerOptions $options){
        try{
            //todo 执行任务事件--统一前置方法
            //检验最大执行次数
            if($job->maxTries() > $options->maxTries){
                echo "超过最大执行次数";
            }
            //执行任务
            $job->run();

            //todo 执行任务事件--统一前置方法
        }catch(\Exception $ex){
            $job->failed($ex);
        }
    }

}