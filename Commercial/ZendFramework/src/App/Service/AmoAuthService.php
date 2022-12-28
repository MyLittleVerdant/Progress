<?php

declare(strict_types=1);

namespace App\Service;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Helper\Logger;
use App\Model\User;
use App\Repository\UserRepository;
use Exception;
use League\OAuth2\Client\Token\AccessToken;

class AmoAuthService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param AmoCRMApiClient $apiClient
     * @param string $code
     * @return \League\OAuth2\Client\Token\AccessTokenInterface|void
     */
    public function getOriginToken(AmoCRMApiClient $apiClient, string $code)
    {
        try {
            $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($code);
        } catch (Exception $e) {
            Logger::Log($e->getMessage());
            die("Cant find storage file");
        }

        return $accessToken;
    }


    /**
     * @param AmoCRMApiClient $apiClient
     * @param AccessToken $accessToken
     * @param User $user
     * @return void
     */
    public function refreshToken(AmoCRMApiClient &$apiClient, AccessToken &$accessToken, User $user)
    {
        $apiClient->getOAuthClient()->setBaseDomain($accessToken->getValues()['baseDomain']);

        try {
            $accessToken = $apiClient->getOAuthClient()->getAccessTokenByRefreshToken($accessToken);

            $user->setAccessToken($accessToken->getToken());
            $user->setRefreshToken($accessToken->getRefreshToken());
            $user->setExpires($accessToken->getExpires());
            $user->setReferer($apiClient->getAccountBaseDomain());

            $this->userRepository->save($user);
        } catch (AmoCRMoAuthApiException $e) {
            Logger::Log($e->getDescription());
            die("Auth error");
        } catch (Exception $e) {
            Logger::Log($e->getMessage());
            die("Refresh token error");
        }
        $apiClient->setAccessToken($accessToken);
    }

    /**
     * @param User $user
     * @param AmoCRMApiClient $apiClient
     * @return AccessToken|null
     */
    public function buildToken(User $user, AmoCRMApiClient &$apiClient): ?AccessToken
    {
        if (empty($user->getAccessToken()) ||
            empty($user->getRefreshToken()) ||
            empty($user->getExpires()) ||
            empty($user->getReferer())
        ) {
            return null;
        }
        $accessToken = new AccessToken([
            'access_token' => $user->getAccessToken(),
            'refresh_token' => $user->getRefreshToken(),
            'expires' => $user->getExpires(),
            'baseDomain' => $user->getReferer(),
        ]);

        if ($accessToken->hasExpired()) {
            $this->refreshToken($apiClient, $accessToken, $user);
        } else {
            $apiClient->getOAuthClient()->setBaseDomain($accessToken->getValues()['baseDomain']);
            $apiClient->setAccessToken($accessToken);
        }

        return $accessToken;
    }
}