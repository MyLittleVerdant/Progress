<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Unisender\ApiWrapper\UnisenderApi;

class UnisenderHandler implements RequestHandlerInterface
{
    private UnisenderApi $unisender;

    public function __construct(UnisenderApi $unisender)
    {
        $this->unisender = $unisender;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $contacts = $this->unisender->getContact(["email" => "test@test.com"]);

        return new JsonResponse($contacts);
    }
}