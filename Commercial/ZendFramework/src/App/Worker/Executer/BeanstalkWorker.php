<?php

declare(strict_types=1);

namespace App\Worker\Executer;

use App\Worker\Model\Beanstalk;
use Pheanstalk\Contract\PheanstalkInterface;
use Pheanstalk\Job;
use Pheanstalk\Pheanstalk;
use Throwable;

abstract class BeanstalkWorker
{
    /** @var Pheanstalk Текущее подключение к серверу очередей. */
    protected Pheanstalk $connection;

    /** @var string Просматриваемая очередь */
    protected string $queue = 'default';

    /**
     * Constructor BaseWorker
     * @param Beanstalk $beanstalk
     */
    public function __construct(Beanstalk $beanstalk)
    {
        $this->connection = $beanstalk->getConnection();
    }

    /** Вызов через CLI */
    public function execute()
    {
        while ($job = $this->connection
            ->watchOnly($this->queue)
            ->ignore(PheanstalkInterface::DEFAULT_TUBE)
            ->reserve()
        ) {
            try {
                $this->process(json_decode($job->getData(), true, 512, JSON_THROW_ON_ERROR));
            } catch (Throwable $exception) {
                $this->handleException($exception, $job);
            }

            $this->connection->delete($job);
        }
    }

    /**
     * @param Throwable $exception
     * @param Job $job
     */
    private function handleException(Throwable $exception, Job $job): void
    {
        echo "Error Unhandled exception $exception" . PHP_EOL . $job->getData();
    }

    /** Обработка задачи. */
    abstract public function process($data);
}
