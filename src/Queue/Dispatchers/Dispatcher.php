<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/14
 * Time: 下午2:47
 */

namespace XYLibrary\Queue\Dispatchers;


class Dispatcher
{
    public function __construct()
    {
    }

    public function dispatch($command){
        $manager = call_user_func(app('manager'));
        $queue = $manager->connection();
        $this->dispatchToQueue($command,$queue);
    }

    public function dispatchToQueue($command,$queue){
        if(isset($command->delay)){
            $queue->pushOn();
        }else{
            $queue->laterOn();
        }
    }

}