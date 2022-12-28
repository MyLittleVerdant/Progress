<?php

namespace App\Worker\Model;

use Pheanstalk\Pheanstalk;

class Beanstalk
{
    private ?Pheanstalk $connection;

    public function __construct(array $config)
    {
        $this->connection = Pheanstalk::create(
            $config['host'],
            $config['port'],
            $config['timeout']
        );
    }

    public function getConnection(): ?Pheanstalk
    {
        return $this->connection;
    }

}