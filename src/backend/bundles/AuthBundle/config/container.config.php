<?php
namespace Application;

use Auth\Middleware\AuthMiddleware;
use Auth\Middleware\AuthMiddlewareFactory;
use Auth\Service\AuthService;
use Auth\Service\AuthServiceFactory;

return [
    'factories' => [
        AuthService::class => AuthServiceFactory::class,
        AuthMiddleware::class => AuthMiddlewareFactory::class
    ]
];