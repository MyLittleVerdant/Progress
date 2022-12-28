<?php

declare(strict_types=1);

namespace App\Factory;

use AmoCRM\Client\AmoCRMApiClient;
use Psr\Container\ContainerInterface;

class AmoApiClientFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get("config");
        $apiClient = new AmoCRMApiClient($config['INTEG_ID'], $config['CSECRET'], $config['REDIR_URI']);
        $apiClient->setAccountBaseDomain("www.kommo.com");

        return $apiClient;
    }
}