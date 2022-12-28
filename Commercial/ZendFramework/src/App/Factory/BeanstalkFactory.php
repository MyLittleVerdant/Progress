<?php

namespace App\Factory;

use App\Worker\Model\Beanstalk;
use Psr\Container\ContainerInterface;

class BeanstalkFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get("config");

        return new Beanstalk($config["beanstalk"]);
    }
}