<?php

declare(strict_types=1);

namespace App;

use AmoCRM\Client\AmoCRMApiClient;
use App\Command\HowTime;
use App\Command\RefreshToken;
use App\Command\Synchronize;
use App\Factory\AddUserHandlerFactory;
use App\Factory\AmoApiClientFactory;
use App\Factory\AuthenticationHandlerFactory;
use App\Factory\AuthorizationHandlerFactory;
use App\Factory\BeanstalkFactory;
use App\Factory\ContactsHandlerFactory;
use App\Factory\HowTimeFactory;
use App\Factory\JobHandlerFactory;
use App\Factory\RefreshTokenFactory;
use App\Factory\SyncContactsHandlerFactory;
use App\Factory\SynchronizeFactory;
use App\Factory\UnisenderHandlerFactory;
use App\Factory\UserRepositoryFactory;
use App\Handler\AddUserHandler;
use App\Handler\AuthenticationHandler;
use App\Handler\AuthorizationHandler;
use App\Handler\ContactsHandler;
use App\Handler\JobHandler;
use App\Handler\SyncContactsHandler;
use App\Handler\UnisenderHandler;
use App\Repository\UserRepository;
use App\Worker\Model\Beanstalk;


/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates' => $this->getTemplates(),
            'laminas-cli' => $this->getCliConfig(),

        ];
    }

    public function getCliConfig(): array
    {
        return [
            'commands' => [
                'how-time' => HowTime::class,
                'synchronize' => Synchronize::class,
                'reftoken' => RefreshToken::class
            ],
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories' => [
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
                AuthorizationHandler::class => AuthorizationHandlerFactory::class,
                AuthenticationHandler::class => AuthenticationHandlerFactory::class,
                ContactsHandler::class => ContactsHandlerFactory::class,
                AmoCRMApiClient::class => AmoApiClientFactory::class,
                UnisenderHandler::class => UnisenderHandlerFactory::class,
                SyncContactsHandler::class => SyncContactsHandlerFactory::class,
                AddUserHandler::class => AddUserHandlerFactory::class,
                UserRepository::class => UserRepositoryFactory::class,

                Beanstalk::class => BeanstalkFactory::class,

                HowTime::class => HowTimeFactory::class,
                JobHandler::class => JobHandlerFactory::class,
                Synchronize::class => SynchronizeFactory::class,
                RefreshToken::class => RefreshTokenFactory::class,

            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app' => ['templates/app'],
                'error' => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
