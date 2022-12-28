<?php

declare(strict_types=1);

namespace App\Handler;

use AmoCRM\Client\AmoCRMApiClient;
use App\Repository\UserRepository;
use App\Service\AmoAuthService;
use App\Service\ContactService;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ContactsHandler implements RequestHandlerInterface
{
    private AmoCRMApiClient $apiClient;
    private ContactService $contactService;
    private UserRepository $userRepository;
    private AmoAuthService $amoAuthService;

    public function __construct(
        AmoCRMApiClient $apiClient,
        ContactService $contactService,
        UserRepository $userRepository,
        AmoAuthService $amoAuthService
    ) {
        $this->apiClient = $apiClient;
        $this->contactService = $contactService;
        $this->userRepository = $userRepository;
        $this->amoAuthService = $amoAuthService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $user = $this->userRepository->findOneByID($params["acc_id"] ?? '0');

        $accessToken = $this->amoAuthService->buildToken($user, $this->apiClient);

        if (empty($accessToken)) {
            return new TextResponse("Go to 'URL/auth' to sign in");
        }

        $allContacts = [];
        $iterations = $this->contactService->getIterCount($this->apiClient);

        for ($i = 1; $i <= $iterations; $i++) {
            $contacts = $this->contactService->getContacts($this->apiClient, $i);
            $allContacts = array_merge($allContacts, $contacts);
        }

        return new JsonResponse($allContacts);
    }
}