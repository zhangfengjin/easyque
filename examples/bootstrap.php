<?php
require_once __DIR__ . "/../vendor/autoload.php";

$config = require_once __DIR__ . "/config/queue.php";

use XYLibrary\Queue\QueueProvider;
$provider = new QueueProvider($config);
$provider->register();

