<?php
namespace Auth;

use Auth\Middleware\AuthMiddleware;
use Auth\Middleware\AuthMiddlewareFactory;
use Auth\Service\AuthService;
use Auth\Service\AuthServiceFactory;

return [
    'zend_service_manager' => [
        'factories' => [
            AuthService::class => AuthServiceFactory::class,
            AuthMiddleware::class => AuthMiddlewareFactory::class
        ]
    ]
];