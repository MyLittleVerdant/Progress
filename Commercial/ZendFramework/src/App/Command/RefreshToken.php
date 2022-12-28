<?php

namespace App\Command;

use App\Repository\UserRepository;
use App\Worker\Executer\RefreshTokenWorker;
use App\Worker\Model\Beanstalk;
use Pheanstalk\Pheanstalk;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshToken extends Command
{
    protected Beanstalk $queue1;
    protected Pheanstalk $queue2;

    public function __construct($queue, string $name = null)
    {
        parent::__construct($name);
        $this->queue1 = $queue;
        $this->queue2 = $queue->getConnection();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
//        $users = (new UserRepository())->findByExpires();
        $users = [30666543];
        foreach ($users as $user) {
            $this->queue2
                ->useTube('refresh_token')
                ->put(
                    json_encode($user),
                );
        }

        (new RefreshTokenWorker(
            ($this->queue1)
        ))->execute();

        return 0;
    }


}