<?php

namespace App\Worker\Executer;

use AmoCRM\Client\AmoCRMApiClient;
use App\Repository\UserRepository;
use App\Service\AmoAuthService;
use App\Worker\Model\Beanstalk;
use League\OAuth2\Client\Token\AccessToken;

class RefreshTokenWorker extends BeanstalkWorker
{
    protected string $queue = 'refresh_token';

    public function __construct(Beanstalk $queue)
    {
        parent::__construct($queue);
    }

    /**
     * @param $data
     * @return int
     */
    public function process($data): int
    {
        $config = include "./config/config.php";
        $apiClient = new AmoCRMApiClient($config['INTEG_ID'], $config['CSECRET'], $config['REDIR_URI']);

        $amoAuthService = new AmoAuthService(new UserRepository());

        $user = (new UserRepository())->findOneByID((string)$data);

        $accessToken = new AccessToken([
            'access_token' => $user->getAccessToken(),
            'refresh_token' => $user->getRefreshToken(),
            'expires' => $user->getExpires(),
            'baseDomain' => $user->getReferer(),
        ]);
        $apiClient->setAccessToken($accessToken);
        $apiClient->setAccountBaseDomain($user->getReferer());

        $amoAuthService->refreshToken($apiClient, $accessToken, $user);

        echo "Done!\n";

        return 1;
    }

}