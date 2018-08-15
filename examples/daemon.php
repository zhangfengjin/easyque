<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/15
 * Time: 下午2:59
 */
require_once __DIR__ . "/../vendor/autoload.php";

$config = require_once __DIR__ . "/config/queue.php";

use XYLibrary\Queue\Daemon;

$daemon = new Daemon($config);
$daemon->run($argv);