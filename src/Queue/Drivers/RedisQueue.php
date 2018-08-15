<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/13
 * Time: 下午4:34
 */

namespace XYLibrary\Queue\Drivers;


use Predis\Client;
use XYLibrary\Queue\Jobs\RedisJob;
use XYLibrary\Queue\LuaScripts;

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
        $this->redis->zadd($this->getQueue($queue).":delayed",$delay,$payload);
        return true;
    }

    /**
     * 弹出队列任务
     * @param $queue
     * @return RedisJob
     */
    public function pop($queue){
        //todo
        //1.delay=>default,到期的延迟任务写入待执行队列
        $prefixed = $this->getQueue($queue);
        $this->migrate($prefixed);
        //2.从待执行队列获取一条放入执行中队列
        list($job, $reserved) = $this->retrieveNextJob($prefixed);
        if ($reserved) {
            return new RedisJob($this, $job, $reserved, $queue);
        }
    }

    /**
     * 从执行中队列删除任务(成功后删除)
     * @param $queue
     * @param $job
     */
    public function deleteReserved($queue, $job)
    {
        $this->redis->zrem($this->getQueue($queue).':reserved', $job);
    }

    /**
     * 将任何延迟或过期的作业迁移到主队列中
     * @param  string  $queue
     * @return void
     */
    protected function migrate($queue)
    {
        //将延迟队列中的到期执行任务 放入到待执行队列中
        $this->migrateExpiredJobs($queue.':delayed', $queue);
    }

    /**
     *
     * @param  string  $from
     * @param  string  $to
     * @return array
     */
    public function migrateExpiredJobs($from, $to)
    {
        return $this->redis->eval(
            LuaScripts::migrateExpiredJobs(), 2, $from, $to, time()
        );
    }

    /**
     * @param $queue
     * @return mixed
     */
    protected function retrieveNextJob($queue)
    {
        if (! is_null(null)) {//queue.php配置文件中是否设置阻塞等待block_for
            //todo 使用阻塞式有丢失任务的风险,无法保证原子性
            //原因:该实现会先从队列中blpop取出队列任务,然后将任务放入正在执行队列,若放入正在执行队列之前,队列崩溃,则队列丢失;
            //return $this->blockingPop($queue);
        }
        //利用lua脚本,实现从待执行队列到执行队列的原子性
        return $this->redis->eval(
            LuaScripts::pop(), 2, $queue, $queue.':reserved',10
        );
    }

    private function getQueue($queue){
        return "queues:" . ($queue ? $queue : $this->queue);
    }
}