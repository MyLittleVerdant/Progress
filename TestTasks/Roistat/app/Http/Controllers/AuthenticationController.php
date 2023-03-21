<?php

namespace App\Http\Controllers;

use AmoCRM\Client\AmoCRMApiClient;
use Illuminate\Http\RedirectResponse;

class AuthenticationController extends Controller
{
    private AmoCRMApiClient $apiClient;

    public function __construct()
    {
        $this->apiClient = new AmoCRMApiClient(config()->get('amoKeys.INTEG_ID'),
            config()->get('amoKeys.CSECRET'), config()->get('amoKeys.REDIR_URI'));
    }

    public function index(): RedirectResponse
    {

        $state = bin2hex(random_bytes(16));

        $authorizationUrl = $this->apiClient->getOAuthClient()->getAuthorizeUrl([
            'mode' => 'post_message',
            'state' => $state,
        ]);
        return redirect()->away($authorizationUrl);
    }
}
