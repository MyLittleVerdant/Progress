<?php

declare(strict_types=1);

namespace App\Handler;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Models\AccountModel;
use AmoCRM\Models\WebhookModel;
use App\Helper\Logger;
use App\Model\User;
use App\Repository\UserRepository;
use App\Service\AmoAuthService;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthorizationHandler implements RequestHandlerInterface
{
    private AmoCRMApiClient $apiClient;
    private AmoAuthService $amoAuthService;
    private string $url;
    private UserRepository $userRepository;

    public function __construct(
        AmoCRMApiClient $apiClient,
        AmoAuthService $amoAuthService,
        UserRepository $userRepository,
        string $url
    ) {
        $this->apiClient = $apiClient;
        $this->amoAuthService = $amoAuthService;
        $this->userRepository = $userRepository;
        $this->url = $url;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();

        if (isset($params['referer'])) {
            $user = $this->userRepository->findOneByDomain($params["referer"]);
            $this->apiClient->setAccountBaseDomain($params['referer']);
        }

        if (empty($user)) {
            if (isset($params['code'])) {
                $accessToken = $this->amoAuthService->getOriginToken($this->apiClient, $params['code']);
                $this->apiClient->setAccessToken($accessToken);
            } else {
                return new TextResponse("Go to 'URL/auth' to sign in");
            }
        } else {
            $accessToken = $this->amoAuthService->buildToken($user, $this->apiClient);
            $this->apiClient->setAccessToken($accessToken);
        }


        //Получение инфы об аккаунте
        try {
            $account = $this->apiClient->account()->getCurrent(AccountModel::getAvailableWith());
        } catch (AmoCRMApiException $e) {
            Logger::Log($e->getMessage());
            die("Can't get account data");
        }

        //Получение инфы о пользователе
        $ownerDetails = $this->apiClient->getOAuthClient()->getResourceOwner($accessToken);

        if (empty($user)) {
            $user = new User();
            $user->setId($account->getId());
            $user->setAccessToken($accessToken->getToken());
            $user->setRefreshToken($accessToken->getRefreshToken());
            $user->setExpires($accessToken->getExpires());
            $user->setReferer($this->apiClient->getAccountBaseDomain());

            $this->userRepository->save($user);
        }
        $this->subscribe();

        return new HtmlResponse('Hello, ' . $ownerDetails->getName());
    }

    private function subscribe()
    {
        $webHookModel = (new WebhookModel())
            ->setSettings(['add_contact', 'update_contact'])
            ->setDestination($this->url . "sync");

        try {
            $this->apiClient->webhooks()->subscribe($webHookModel)->toArray();
        } catch (AmoCRMApiException $e) {
            Logger::Log($e->getMessage());
            die("Can't subscribe on hook");
        }
    }


}