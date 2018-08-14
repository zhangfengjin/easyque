<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/14
 * Time: 下午3:08
 */

namespace XYLibrary\Queue;


use Predis\Client;
use XYLibrary\Queue\Connectors\RedisConnector;

class QueueProvider
{
    protected $config;
    public function __construct($config)
    {
        require_once __DIR__.'/Utils/helpers.php';
        $this->config = $config;
    }

    public function register(){
        $this->registerQueue();
        $this->registerConfig();
        $this->registerRedis();
    }

    /**
     *
     */
    protected function registerConfig(){
        singleton("config",$this->config);
    }

    /**
     * 聚财队列
     */
    protected function registerQueue(){
        singleton("manager",function(){
            $manager = new QueueManager();
            $this->registerRedisConnector($manager);
            return $manager;
        });
    }

    /**
     * 注册redis连接器
     * @param QueueManager $manager
     */
    protected function registerRedisConnector(QueueManager $manager){
        $manager->addConnector("redis",function(){
            return new RedisConnector();
        });
    }

    protected function registerRedis(){
        singleton("redis",$this->getRedis());
    }

    /**
     * 获取redis具体操作连接
     * @return Client
     */
    private function getRedis(){
        switch($this->driver['client']){
            case "predis":
                return $this->getPRedisConnection();
                break;
            case "":
                break;
        }
    }

    /**
     * 获取PRedis连接实例
     * @return Client
     */
    private function getPRedisConnection(){
        $parameters = $this->driver['default'];
        $options = array_merge(["timeout"=>10.0],$parameters["options"]);
        return new Client($parameters,$options);
    }



}