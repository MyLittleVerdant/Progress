<?php

declare(strict_types=1);

namespace App\Handler;

use AmoCRM\Client\AmoCRMApiClient;
use App\Helper\Logger;
use App\Repository\UserRepository;
use App\Service\AmoAuthService;
use App\Service\ContactService;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\TextResponse;
use Pheanstalk\Job;
use Pheanstalk\Pheanstalk;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Unisender\ApiWrapper\UnisenderApi;

class SyncContactsHandler implements RequestHandlerInterface
{
    private AmoCRMApiClient $apiClient;
    private AmoAuthService $amoAuthService;
    private UserRepository $userRepository;
    private ContactService $contactService;
    private Pheanstalk $queue;


    public function __construct(
        AmoCRMApiClient $apiClient,
        AmoAuthService $amoAuthService,
        UserRepository $userRepository,
        ContactService $contactService,
        Pheanstalk $queue
    ) {
        $this->apiClient = $apiClient;
        $this->amoAuthService = $amoAuthService;
        $this->userRepository = $userRepository;
        $this->contactService = $contactService;
        $this->queue = $queue;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();

        $user = $this->userRepository->findOneByID($params["accountId"] ?? $params["account"]["id"]);
        if (empty($user)) {
            Logger::Log("No account id in request");
            die("Non enough data provided");
        }
        if (!empty($params["token"]) && !empty($params["listId"])) {
            $user->setUnisenderToken($params["token"]);
            $user->setUniList(((int)$params["listId"]));
            $this->userRepository->save($user);
        }

        $accessToken = $this->amoAuthService->buildToken($user, $this->apiClient);

        if (empty($accessToken)) {
            return new TextResponse("Go to 'URL/auth' to sign in");
        }
        if (empty($params["contacts"])) { //массовый ручной импорт
            $iterations = $this->contactService->getIterCount($this->apiClient);
            for ($i = 1; $i <= $iterations; $i++) {
                $contacts = $this->contactService->getContacts($this->apiClient, $i);
                $contacts = $this->contactService->filterContacts($contacts);
                $contacts = $this->subscribeTo($user->getUniList(), $contacts);
            }
        } else {                            //импорт из хука
            $contacts = $this->contactService->hasEmail($params["contacts"]);
            $contacts = $this->subscribeTo($user->getUniList(), $contacts);
        }

        if ($this->sync($contacts, $user->getId())) {
            Logger::Log("Sync success");
        }

        return new HtmlResponse("Success");
    }

    private function sync(array $contacts, int $userID): bool
    {
        $iterations = ceil(count($contacts) / 500);

        for ($i = 0; $i < $iterations; $i++) {
            $this->queue
                ->useTube('account_sync')
                ->put(
                    json_encode(["userID" => $userID, "iteration" => $i, "contacts" => $contacts]),
                );
        }
        return true;
    }

    /**
     * Указывает id списка, в который добавить контакты
     * @param int $id
     * @param array $contacts
     * @return array
     */
    private function subscribeTo(int $id, array $contacts): array
    {
        foreach ($contacts as &$contact) {
            $contact["id"] = $id;
            $contact = array_values($contact);
        }

        return array_values($contacts);
    }

}