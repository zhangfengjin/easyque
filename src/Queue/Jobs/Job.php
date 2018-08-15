<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/15
 * Time: 下午6:08
 */

namespace XYLibrary\Queue\Jobs;


class Job
{

    /**
     * 执行任务
     */
    public function run(){
        //获取任务详情
        $payload = $this->payload();
        //解析job XYLibrary\Queue\CallQueuedHandler@call
        list($class, $method) = explode("@",$payload['job']);

        $instance = new $class();

        $instance->{$method}($this, $payload['data']);
    }

    /**
     * 删除
     */
    public function delete(){
        $this->deleteReserved();
    }

    public function failed($ex){
        $payload = $this->payload();
        //解析job XYLibrary\Queue\CallQueuedHandler@call
        list($class, $method) = explode("@",$payload['job']);

        $instance = new $class();
        if (method_exists($instance, 'failed')) {
            //回调业务列失败方法
            $instance->failed($payload['data'], $ex);
        }
        //todo 获取重试attempts次数 是否大于maxTries
        //1.attempts>=maxTries 放入失败队列
        //2.attempts<maxTries 放入延迟队列(即延迟一段时间$instance->retryDelay继续执行)
    }

    /**
     * @return mixed
     */
    public function payload()
    {
        return json_decode($this->getRawBody(), true);
    }

    /**
     * Get the number of times to attempt a job.
     *
     * @return int|null
     */
    public function maxTries()
    {
        return $this->payload()['maxTries'] ?? null;
    }
}