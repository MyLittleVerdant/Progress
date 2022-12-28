<?php

namespace App\Factory;

use App\Command\Synchronize;
use App\Worker\Model\Beanstalk;

class SynchronizeFactory
{
    public function __invoke($container)
    {
        $queue = $container->get(Beanstalk::class);

        return new Synchronize($queue, null);
    }
}