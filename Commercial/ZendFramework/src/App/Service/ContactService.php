<?php

declare(strict_types=1);

namespace App\Service;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Exceptions\AmoCRMApiNoContentException;
use AmoCRM\Filters\ContactsFilter;
use App\Helper\Logger;
use Error;
use Exception;

class ContactService
{
    private const LIMIT = 250;

    public function getContacts(AmoCRMApiClient $apiClient, int $page)
    {
        try {
            $filter = new ContactsFilter();
            $filter->setLimit($this::LIMIT);
            $filter->setPage($page);

            $contacts = $apiClient->contacts()->get($filter);
            $contacts = $this->parseContacts($contacts);
        } catch (AmoCRMApiNoContentException $e) {
            Logger::Log($e->getMessage());
            die("No data");
        } catch (Exception $e) {
            Logger::Log($e->getMessage());
            die("Error");
        }

        return $contacts;
    }

    public function getIterCount(AmoCRMApiClient $apiClient)
    {
        try {
            $count = $apiClient->contacts()->get()->count();

            return ceil($count / $this::LIMIT);
        } catch (AmoCRMApiNoContentException $e) {
            Logger::Log($e->getMessage());
            die("No data");
        } catch (Exception $e) {
            Logger::Log($e->getMessage());
            die("Error");
        }
    }

    /**
     * Убрать все контакты без email
     * @param array $contacts
     * @return array
     */
    public function filterContacts(array $contacts): array
    {
        foreach ($contacts as $key => $contact) {
            if (empty($contact["email"])) {
                unset($contacts[$key]);
            }
        }

        return $contacts;
    }

    /**
     * Обрабатывает контакт, пришедший с веб хука, и возвращает готовый элемент массива для добавления или NULL
     * @param array $contact
     * @return array|null
     */
    public function hasEmail(array $contact): ?array
    {
        $contact = !empty($contact["add"]) ? $contact["add"][0] : (!empty($contact["update"]) ? $contact["update"][0] : null);

        if (!empty($contact["custom_fields"])) {
            foreach ($contact["custom_fields"] as $field) {
                if ($field["name"] === "Email") {
                    return [
                        [
                            "name" => $contact["name"],
                            "email" => $field["values"][0]["value"]
                        ]
                    ];
                }
            }
        }

        return [];
    }

    private function parseContacts(ContactsCollection $contacts): array
    {
        $contactList = [];

        foreach ($contacts as $contact) {
            //Получим коллекцию значений полей контакта
            $customFields = $contact->getCustomFieldsValues();

            //Получим значение поля по его ID
            try {
                $emailField = $customFields->getBy('fieldCode', 'EMAIL');
            } catch (Error $e) {
                Logger::Log("Клиент " . $contact->id . " не имеет поля email");
            }

            $emailObj = null;
            if (!empty($emailField)) {
                $emailObj = $emailField->getValues()->toArray();
            }
            $contactList[] = [
                'name' => $contact->name,
                "email" => $emailObj[0]['value'] ?? null
            ];
        }

        return $contactList;
    }
}