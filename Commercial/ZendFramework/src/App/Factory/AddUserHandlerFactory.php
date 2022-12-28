<?php

declare(strict_types=1);

namespace App\Factory;

use App\Handler\AddUserHandler;
use Psr\Container\ContainerInterface;

class AddUserHandlerFactory
{
    public function __invoke(ContainerInterface $container): AddUserHandler
    {
        return new AddUserHandler();
    }
}