<?php

declare(strict_types=1);

namespace App\Factory;

use AmoCRM\Client\AmoCRMApiClient;
use App\Handler\AuthorizationHandler;
use App\Repository\UserRepository;
use App\Service\AmoAuthService;
use Psr\Container\ContainerInterface;

class AuthorizationHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $apiClient = $container->get(AmoCRMApiClient::class);
        $config = $container->get("config");
        $userRepository = $container->get(UserRepository::class);

        $amoAuthService = new AmoAuthService($userRepository);

        return new AuthorizationHandler($apiClient, $amoAuthService, $userRepository, $config["REDIR_URI"]);
    }

}