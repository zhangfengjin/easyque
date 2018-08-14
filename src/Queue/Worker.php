<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/13
 * Time: 下午4:41
 */

namespace XYLibrary\Queue;


class Worker
{

    public function getNextJob(){
        $connection = app('queue')->connection();
        $connection->pop("key");
    }

}