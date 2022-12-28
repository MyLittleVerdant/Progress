<?php

namespace App\Command;

use App\Worker\Executer\TimeWorker;
use App\Worker\Model\Beanstalk;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HowTime extends Command
{
    protected Beanstalk $queue;

    public function __construct($queue,string $name = null)
    {
        parent::__construct($name);
        $this->queue = $queue;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        (new TimeWorker(
            ($this->queue)
        ))->execute();

//        $output->writeln("Done");

        return 0;
    }
}