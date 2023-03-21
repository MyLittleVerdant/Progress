<?php

namespace App\Services;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\AmoTokenModel;
use Exception;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

class AmoAuthService
{
    /**
     * @param AmoCRMApiClient $apiClient
     * @param AmoTokenModel $token
     * @param string $code
     * @return AccessTokenInterface|void
     */
    public function getOriginToken(AmoCRMApiClient $apiClient, AmoTokenModel $token, string $code)
    {
        try {
            $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($code);

            if (!$accessToken->hasExpired()) {
                $token->set('accessToken', $accessToken->getToken());
                $token->set('refreshToken', $accessToken->getRefreshToken());
                $token->set('expires', (string)$accessToken->getExpires());
                $token->set('baseDomain', $apiClient->getAccountBaseDomain());
            }
        } catch (Exception $e) {
            die("Cant find storage file");
        }

        return $accessToken;
    }

    /**
     * @param AmoTokenModel $token
     * @return AccessToken|null
     */
    public function buildToken(AmoTokenModel $token): ?AccessToken
    {
        if (!empty($token->get("accessToken")) &&
            !empty($token->get("refreshToken")) &&
            !empty($token->get("expires")) &&
            !empty($token->get("baseDomain"))
        ) {
            return new AccessToken([
                'access_token' => $token->get("accessToken"),
                'refresh_token' => $token->get("refreshToken"),
                'expires' => $token->get("expires"),
                'baseDomain' => $token->get("baseDomain"),
            ]);
        } else {
            return null;
        }
    }
}
