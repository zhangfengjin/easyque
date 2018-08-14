<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/13
 * Time: 下午2:24
 */

namespace XYLibrary\Queue\Dispatchers;


class PendingDispatcher
{
    public $job;

    protected $dispatcher;

    public function __construct($job)
    {
        $this->job = $job;
    }

    /**
     *
     * @param $queue
     * @return $this
     */
    public function onQueue($queue){
        $this->job->onQueue($queue);
        return $this;
    }

    /**
     * @param $delay
     * @return $this
     */
    public function delay($delay){
        $this->job->delay($delay);
        return $this;
    }

    public function chain($chain){
        $this->job->chain($chain);
        return $this;
    }

    /**
     * 在脚本结束时(或unset null 即无引用时)执行
     */
    public function __destruct()
    {
        if(!$this->dispatcher){
            $this->dispatcher = new Dispatcher();
        }
        $this->dispatcher->dispatch($this->job);
    }

}