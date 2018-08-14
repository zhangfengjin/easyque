<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/10
 * Time: 下午2:40
 */

namespace XYLibrary\Queue;


use XYLibrary\Queue\Dispatchers\Dispatcheable;
use XYLibrary\Queue\Dispatchers\PendingChain;
use XYLibrary\Queue\Dispatchers\PendingDispatcher;

class Job
{
    use Dispatcheable;
    /**
     * 普通任务
     * @return PendingDispatcher
     */
    public static function dispatch(){
        return new PendingDispatcher(new static(...func_get_args()));
    }

    /**
     * 链式任务
     * @param $chain
     * @return PendingChain
     */
    public static function withChain($chain){
        return new PendingChain(get_called_class(),$chain);
    }

}