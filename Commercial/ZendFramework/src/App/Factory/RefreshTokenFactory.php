<?php

namespace App\Factory;

use App\Command\RefreshToken;
use App\Worker\Model\Beanstalk;

class RefreshTokenFactory
{
    public function __invoke($container)
    {
        $queue = $container->get(Beanstalk::class);

        return new RefreshToken($queue, null);
    }
}