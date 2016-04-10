<?php
namespace Auth;

use Auth\Factory\Middleware\ProtectedMiddlewareFactory;
use Auth\Factory\Service\CurrentProfileServiceFactory;
use Auth\Middleware\AuthMiddleware;
use Auth\Factory\Middleware\AuthMiddlewareFactory;
use Auth\Middleware\ProtectedMiddleware;
use Auth\Service\AuthService;
use Auth\Factory\Service\AuthServiceFactory;
use Auth\Service\CurrentProfileService;

return [
    'zend_service_manager' => [
        'factories' => [
            AuthService::class => AuthServiceFactory::class,
            AuthMiddleware::class => AuthMiddlewareFactory::class,
            ProtectedMiddleware::class => ProtectedMiddlewareFactory::class,
            CurrentProfileService::class => CurrentProfileServiceFactory::class
        ]
    ]
];