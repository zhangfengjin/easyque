<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2018/8/10
 * Time: 下午2:44
 */

namespace Examples\Job;

use XYLibrary\Queue\Job;


class SendEmailJob extends Job
{
    public function beforeJob(){
        echo "beforeJob";
    }

    public function run(){
        echo "exec sendemail job";
    }

    public function afterJob(){
        echo "afterJob";
    }
}