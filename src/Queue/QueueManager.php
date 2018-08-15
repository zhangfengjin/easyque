<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/14
 * Time: 下午3:07
 */

namespace XYLibrary\Queue;


class QueueManager
{
    protected $connections;

    protected $connectors;

    /**
     * @param $driver
     * @param \Closure $closure
     */
    public function addConnector($driver,\Closure $closure){
        $this->connectors[$driver] = $closure;
    }

    /**
     * 获取队列连接
     * @return mixed
     */
    public function connection(){
        $driver = app('config')['default'];

        if(!isset($this->connections[$driver])){
            $this->connections[$driver] = $this->resolve($driver);
        }

        return $this->connections[$driver];
    }

    /**
     * 解析真实的连接
     * @param $driver
     * @return mixed
     */
    protected function resolve($driver){
        $config = app('config')["driver"][$driver];
        $connect = call_user_func($this->connectors[$driver]);
        return $connect->connect($config);
    }
}