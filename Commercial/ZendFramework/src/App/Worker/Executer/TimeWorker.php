<?php

namespace App\Worker\Executer;

class TimeWorker extends BeanstalkWorker
{
    protected string $queue = 'times';

    public function process($data): void
    {
        echo $data;
    }
}