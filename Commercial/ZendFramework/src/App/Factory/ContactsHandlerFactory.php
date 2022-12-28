<?php

declare(strict_types=1);

namespace App\Factory;

use AmoCRM\Client\AmoCRMApiClient;
use App\Handler\ContactsHandler;
use App\Repository\UserRepository;
use App\Service\AmoAuthService;
use App\Service\ContactService;
use Psr\Container\ContainerInterface;

class ContactsHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $apiClient = $container->get(AmoCRMApiClient::class);
        $userRepository = $container->get(UserRepository::class);

        $contactService = new ContactService();
        $amoAuthService = new AmoAuthService($userRepository);


        return new ContactsHandler($apiClient, $contactService, $userRepository, $amoAuthService);
    }

}