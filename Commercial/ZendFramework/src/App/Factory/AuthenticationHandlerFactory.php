<?php

declare(strict_types=1);

namespace App\Factory;

use AmoCRM\Client\AmoCRMApiClient;
use App\Handler\AuthenticationHandler;
use Psr\Container\ContainerInterface;

class AuthenticationHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $apiClient = $container->get(AmoCRMApiClient::class);

        return new AuthenticationHandler($apiClient);
    }

}