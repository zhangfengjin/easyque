<?php
require __DIR__ . '/bootstrap.php';

use Examples\Job\SendEmailJob;

//调用
$args = "buss job args";
SendEmailJob::dispatch($args)->onQueue("sendemail");

/*SendEmailJob::withChain([
        new SendEmailJob(),
        new SendEmailJob()
])->dispatch($args)->onQueue("emailchain");*/
