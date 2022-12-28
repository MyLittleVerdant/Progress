<?php

declare(strict_types=1);

namespace App\Factory;

use App\Handler\UnisenderHandler;
use Psr\Container\ContainerInterface;
use Unisender\ApiWrapper\UnisenderApi;

class UnisenderHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $unisender = $container->get(UnisenderApi::class);

        return new UnisenderHandler($unisender);
    }

}