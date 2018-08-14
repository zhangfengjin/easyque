<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/13
 * Time: 下午4:40
 */

namespace XYLibrary\Queue\Connectors;


use XYLibrary\Queue\Drivers\RedisQueue;

class RedisConnector implements ConnectorInterface
{
    protected $redis;

    protected $config;

    public function __construct()
    {
    }

    public function connect(array $config)
    {
        $this->redis = app("redis");
        return new RedisQueue($this->redis);
    }


}