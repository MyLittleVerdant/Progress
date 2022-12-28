<?php

declare(strict_types=1);

namespace App\Worker\Executer;

use App\Helper\Logger;
use App\Repository\UserRepository;
use App\Worker\Model\Beanstalk;
use Unisender\ApiWrapper\UnisenderApi;

class AccountSyncWorker extends BeanstalkWorker
{

    protected string $queue = 'account_sync';

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
        $user = (new UserRepository())->findOneByID((string)$data["userID"]);
        if (empty($user)) {
            echo "Can't find user\n";

            return 0;
        }
        $unisender = new UnisenderApi($user->getUnisenderToken());
        $response = $unisender->importContacts(
            [
                'field_names' => ["Name", "email", "email_list_ids"],
                'data' => array_slice($data["contacts"], $data["iteration"] * 500, ($data["iteration"] + 1) * 500 - 1)
            ]
        );

        $response = json_decode($response, true);
        if (!empty($response["result"]['log'][0])) {
            Logger::Log($response["result"]['log'][0]['message']);
            die("Sync error");
        }

        echo "Done!\n";

        return 1;
    }

}