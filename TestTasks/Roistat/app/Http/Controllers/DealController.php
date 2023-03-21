<?php

namespace App\Http\Controllers;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\AmoTokenModel;
use App\Services\AmoAuthService;
use App\Services\DealService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DealController extends Controller
{

    private DealService $dealService;
    private AmoCRMApiClient $apiClient;
    private AmoTokenModel $storage;
    private AmoAuthService $amoAuthService;

    /**
     * @param DealService $dealService
     * @param AmoAuthService $amoAuthService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(
        DealService $dealService,
        AmoAuthService $amoAuthService
    ) {
        $this->dealService = $dealService;
        $this->apiClient = new AmoCRMApiClient(config()->get('amoKeys.INTEG_ID'),
            config()->get('amoKeys.CSECRET'), config()->get('amoKeys.REDIR_URI'));
        $this->amoAuthService = $amoAuthService;
        $this->storage = new AmoTokenModel('token_info.json');
    }

    public function index()
    {
        return view('form');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $accessToken = $this->amoAuthService->buildToken($this->storage);
        $this->apiClient->getOAuthClient()->setBaseDomain($accessToken->getValues()['baseDomain']);
        $this->apiClient->setAccessToken($accessToken);

        $deal = $this->dealService->createOne($request,$this->apiClient);

        if (!$deal) {
            return redirect()->route('deal.index')->with(
                'alerts',
                ['error' => "Can't create deal"]
            );
        }
        return redirect()->route('deal.index')->with(
            'alerts',
            ['success' => "Deal created"]
        );
    }


}


