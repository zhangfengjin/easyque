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
    /**
     * 放入普通队列
     * @param $queue
     * @param $job
     * @param string $data
     */
    public function pushOn($queue, $job, $data = ''){
        $this->push($queue, $job, $data);
    }

    /**
     * 放入延迟队列
     * @param $queue
     * @param $delay
     * @param $job
     * @param string $data
     */
    public function laterOn($queue, $delay, $job, $data = ''){
        $this->delay($queue, $delay, $job, $data);
    }


    /**
     * 装饰队列
     * @param $job
     * @param $data
     * @return array
     */
    protected function createPayload($job,$data){
        $payload = [
            'displayName' => $this->getDisplayName($job),
            'job' => 'XYLibrary\Queue\CallQueuedHandler@call',
            'maxTries' => $job->tries? $job->tries : null,
            'timeout' => $job->timeout? $job->timeout : null,
            //'timeoutAt' => $this->getJobExpiration($job),
            'data' => [
                'commandName' => get_class($job),
                'command' => serialize(clone $job),
            ],
        ];
        return json_encode($payload);
    }

    /**
     * 获取名称
     * @param $job
     * @return string
     */
    private function getDisplayName($job)
    {
        return method_exists($job, 'displayName')? $job->displayName() : get_class($job);
    }
}