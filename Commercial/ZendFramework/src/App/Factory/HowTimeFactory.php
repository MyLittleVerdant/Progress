<?php

namespace App\Factory;

use App\Command\HowTime;
use App\Worker\Model\Beanstalk;

class HowTimeFactory
{
    public function __invoke($container)
    {
        date_default_timezone_set('Europe/Moscow');
        $queue = $container->get(Beanstalk::class);

        return new HowTime($queue, null);
    }
}