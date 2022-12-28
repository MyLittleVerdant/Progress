<?php
declare(strict_types=1);

use App\Factory\CorsMiddlewareFactory;
use Tuupola\Middleware\CorsMiddleware;

return [
    'cors' => [
        "origin" => ["*"],
        "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
        "headers.allow" => [
            'X-Auth-Token',
            'Authorization',
            'Content-Type',
            'Origin',
            'X-Requested-With',
            'Accept',
            'DNT',
            'X-CustomHeader',
            'User-Agent',
            'If-Modified-Since',
            'Access-Control-Allow-Origin',
            'Cache-Control',
            'ngrok-skip-browser-warning'
        ],
        "headers.expose" => [],
        "credentials" => false,
        "cache" => 0,
    ],
    'dependencies' => [
        'factories' => [
            CorsMiddleware::class => CorsMiddlewareFactory::class,
        ]
    ]
];