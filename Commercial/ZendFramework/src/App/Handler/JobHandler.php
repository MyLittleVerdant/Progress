<?php

namespace App\Handler;

use Pheanstalk\Pheanstalk;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Server\RequestHandlerInterface;

class JobHandler implements RequestHandlerInterface
{

    private Pheanstalk $queue;

    public function __construct(Pheanstalk $queue)
    {
        $this->queue=$queue;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface{

        $job = $this->queue
            ->useTube('times')
            ->put(
                json_encode("Now time: " . date("H:i (d.y)")),
            );

        return new JsonResponse([
            'queue' => $this->queue->listTubeUsed(),
            'id' => $job->getId(),
            'data' => $job->getData(),
        ]);
    }

}