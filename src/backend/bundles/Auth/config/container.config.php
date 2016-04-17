<?php
use Account\Repository\AccountRepository;
use Account\Service\AccountService;
use Auth\Middleware\AuthMiddleware;
use Auth\Middleware\ProtectedMiddleware;
use Auth\Service\AuthService;
use Auth\Service\CurrentAccountService;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        AuthService::class => object()->constructor(
            get(AccountService::class),
            get('oauth2_providers')
        ),
        AuthMiddleware::class => object()->constructor(
            get(AuthService::class)
        ),
        ProtectedMiddleware::class => object()->constructor(
            get(CurrentAccountService::class),
            get('constants.prefix')
        ),
        CurrentAccountService::class => object()->constructor(
            get(AccountRepository::class)
        )
    ]
];