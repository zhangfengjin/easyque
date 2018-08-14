<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/13
 * Time: 下午2:24
 */

namespace XYLibrary\Queue\Dispatchers;


class PendingChain
{
    public $class;

    public $chain;

    public function __construct($class,$chain)
    {
        $this->class = $class;
        $this->chain = $chain;
    }

    public function dispatch(){
        return (new PendingDispatcher(
            new $this->class(...func_get_args())
        ))->chain($this->chain);
    }
}