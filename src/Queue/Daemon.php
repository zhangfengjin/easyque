<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/15
 * Time: 下午2:54
 */

namespace XYLibrary\Queue;


class Daemon
{
    protected $config;
    public function __construct($config)
    {
        $this->config = $config;

        $provider = new QueueProvider($config);
        $provider->register();
    }

    public function run($argvs){
        $this->arrayToLower($argvs);
        $handlers = explode(":", $argvs[1]);
        $workerCount = 1;
        $method = "";
        switch (count($handlers)) {
            case 2:
                $method = $handlers[0];
                break;
        }
        $options = $this->resolveOptions($argvs);
        switch ($method) {
            case "stop":
                break;
            case "start":
                $worker = new Worker();
                $worker->daemon($options);
                break;
            case "restart":
                break;
        }
    }

    /**
     * 解析参数
     * @param $argvs
     * @return Queue\WorkerOptions
     */
    protected function resolveOptions($argvs)
    {
        $workerOptions = new WorkerOptions();
        for ($idx = 2; $idx < count($argvs); $idx++) {
            $attributes = explode("=", str_replace("--", "", $argvs[$idx]));
            if (count($attributes) == 2) {
                $key = $attributes[0];
                $values = $attributes[1];
                switch ($key) {
                    case "queue":
                        $workerOptions->queues = $values;
                        break;
                    case "sleep":
                        $workerOptions->sleep = $values;
                        break;
                    case "tries":
                        $workerOptions->maxTries = $values;
                        break;
                }
            }
        }
        return $workerOptions;
    }

    /**
     * 转换为小写
     * @param $argvs
     */
    protected function arrayToLower(&$argvs)
    {
        foreach ($argvs as &$argv) {
            $argv = strtolower($argv);
        }
    }

    public function start(){

    }

    public function stop(){

    }

    public function restart(){

    }

}