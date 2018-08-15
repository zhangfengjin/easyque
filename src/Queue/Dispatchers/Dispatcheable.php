<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/13
 * Time: 下午2:47
 */

namespace XYLibrary\Queue\Dispatchers;


trait Dispatcheable
{
    public $retryDelay;//失败后延迟多久再次执行 默认1s

    public $tries;

    public $timeout;

    public $queue;

    public $delay;

    public $chained;

    public function onQueue($queue){
        $this->queue = $queue;
        return $this;
    }

    public function delay($delay){
        $this->delay = $delay;
        return $this;
    }

    /**
     * 链式任务属性
     * @param $chain
     * @return $this
     */
    public function chain($chain){
        $this->chained = serialize($chain);//序列化下游任务
        return $this;
    }

    /**
     * 分发任务链上的任务
     */
    public function dispatchChainJob(){
        if(!empty($this->chained)){
            //反序列化$this->chained 弹出任务链上的任务 array_shift
            $job = array_shift(unserialize($this->chained));
            $job->onQueue($job->queue);
            $job->daley($job->delay);
            //分发执行任务链上的下个任务
            new PendingDispatcher($job);
        }
    }
}