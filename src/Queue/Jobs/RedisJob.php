<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/13
 * Time: 下午4:34
 */

namespace XYLibrary\Queue\Jobs;


use XYLibrary\Queue\Drivers\RedisQueue;

class RedisJob extends Job
{
    protected $queue;
    protected $job;
    protected $reserved;
    protected $queueName;

    public function __construct(RedisQueue $queue, $job, $reserved, $queueName)
    {
        $this->queue = $queue;
        $this->job = $job;
        $this->reserved = $reserved;
        $this->queueName = $queueName;
    }

    public function getRawBody(){
        return $this->job;
    }

    public function deleteReserved(){
        $this->queue->deleteReserved($this->queueName,$this->reserved);
    }

    public function getReservedJob(){
        return $this->reserved;
    }

}