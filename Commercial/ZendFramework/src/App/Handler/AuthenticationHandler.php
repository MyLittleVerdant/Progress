<?php

declare(strict_types=1);

namespace App\Handler;

use AmoCRM\Client\AmoCRMApiClient;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticationHandler implements RequestHandlerInterface
{
    private AmoCRMApiClient $apiClient;

    public function __construct(AmoCRMApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $state = bin2hex(random_bytes(16));

        $authorizationUrl = $this->apiClient->getOAuthClient()->getAuthorizeUrl([
            'mode' => 'post_message',
            'state' => $state,
        ]);
        return new RedirectResponse($authorizationUrl);
    }


}