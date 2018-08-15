<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/13
 * Time: 下午4:34
 */

namespace XYLibrary\Queue\Drivers;


use Predis\Client;

class RedisQueue extends Queue
{
    protected $redis;
    protected $queue;

    public function __construct(Client $redis,$queue = "default")
    {
        $this->redis = $redis;
        $this->queue = $queue;
    }

    /**
     * 添加队列普通任务
     * @param $queue
     * @param $job
     * @param $data
     * @return bool
     */
    public function push($queue, $job, $data){
        $payload = $this->createPayload($job,$data);
        $this->redis->rpush($this->getQueue($queue),$payload);
        return true;
    }

    /**
     * 添加任务到延迟队列
     * @param $queue
     * @param $delay
     * @param $job
     * @param $data
     * @return bool
     */
    public function delay($queue, $delay, $job, $data){
        $payload = $this->createPayload($job,$data);
        $delay = time() + $delay;
        $this->redis->zadd($this->getQueue($queue).":delay",$delay,$payload);
        return true;
    }

    private function getQueue($queue){
        return "queues:" . ($queue ? $queue : $this->queue);
    }
}