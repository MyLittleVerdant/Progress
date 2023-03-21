<?php

namespace App\Http\Controllers;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\AmoTokenModel;
use App\Services\AmoAuthService;


class AuthorizationController extends Controller
{
    private AmoCRMApiClient $apiClient;
    private AmoAuthService $amoAuthService;
    private AmoTokenModel $storage;

    public function __construct(AmoAuthService $amoAuthService)
    {
        $this->apiClient = new AmoCRMApiClient(config()->get('amoKeys.INTEG_ID'),
            config()->get('amoKeys.CSECRET'), config()->get('amoKeys.REDIR_URI'));
        $this->amoAuthService = $amoAuthService;
        $this->storage = new AmoTokenModel('token_info.json');
    }

    public function index()
    {
        if (isset($_REQUEST['referer'])) {
            $this->apiClient->setAccountBaseDomain($_REQUEST['referer']);
        }

        if (isset($_REQUEST['code'])) {
            $accessToken = $this->amoAuthService->getOriginToken($this->apiClient, $this->storage, $_REQUEST['code']);
        } else {
            return Response("Go to 'URL/auth' to sign in");
        }

        $ownerDetails = $this->apiClient->getOAuthClient()->getResourceOwner($accessToken);

        return Response('Authorization is successful. Hello, ' . $ownerDetails->getName() .
            ". Now you can go to 'URL/deal' to create new deal");
    }
}
