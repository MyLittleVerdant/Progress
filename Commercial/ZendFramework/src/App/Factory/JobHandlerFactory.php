<?php

namespace App\Factory;

use App\Handler\JobHandler;
use App\Worker\Model\Beanstalk;
use Psr\Container\ContainerInterface;

class JobHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        date_default_timezone_set('Europe/Moscow');

        $queue = $container->get(Beanstalk::class);

        return new JobHandler($queue->getConnection());
    }
}