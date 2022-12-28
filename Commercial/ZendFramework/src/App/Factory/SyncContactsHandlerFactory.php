<?php

declare(strict_types=1);

namespace App\Factory;

use AmoCRM\Client\AmoCRMApiClient;
use App\Handler\SyncContactsHandler;
use App\Repository\UserRepository;
use App\Service\AmoAuthService;
use App\Service\ContactService;
use App\Worker\Model\Beanstalk;
use Psr\Container\ContainerInterface;


class SyncContactsHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $apiClient = $container->get(AmoCRMApiClient::class);
        $userRepository = $container->get(UserRepository::class);

        $amoAuthService = new AmoAuthService($userRepository);
        $contactService = new ContactService();


        $queue = $container->get(Beanstalk::class);

        return new SyncContactsHandler(
            $apiClient,
            $amoAuthService,
            $userRepository,
            $contactService,
            $queue->getConnection()
        );
    }
}