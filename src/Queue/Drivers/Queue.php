<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/13
 * Time: 下午4:33
 */

namespace XYLibrary\Queue\Drivers;


class Queue
{
    public function pushOn(){
        echo "pushOn";
    }

    public function laterOn(){
        echo "laterOn";
    }

    protected function createPayload(){}
}