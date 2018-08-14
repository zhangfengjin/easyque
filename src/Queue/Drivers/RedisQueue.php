<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/13
 * Time: 下午4:34
 */

namespace XYLibrary\Queue\Drivers;


class RedisQueue extends Queue
{
    protected $redis;

    public function __construct($redis)
    {
        $this->redis = $redis;
    }

    public function push(){}

    public function delay(){}
}