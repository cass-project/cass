<?php
namespace Domain\Auth;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Account\Repository\AccountRepository;
use Domain\Account\Service\AccountService;
use Domain\Auth\Middleware\AuthMiddleware;
use Domain\Auth\Middleware\ProtectedMiddleware;
use Domain\Auth\Service\AuthService;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Auth\Frontline\AuthTokenScript;
use Application\Frontline\Service\FrontlineService;
use Domain\Auth\Service\PasswordVerifyService;

return [
    'php-di' => [
        AuthService::class => object()->constructor(
            get(AccountService::class),
            get(PasswordVerifyService::class),
            get('oauth2_providers')
        ),
        AuthMiddleware::class => object()->constructor(
            get(AuthService::class),
            get(FrontlineService::class)
        ),
        ProtectedMiddleware::class => object()->constructor(
            get(CurrentAccountService::class),
            get('route-prefix')
        ),
        CurrentAccountService::class => object()->constructor(
            get(AccountRepository::class)
        ),
        AuthTokenScript::class => object()->constructor(
            get(CurrentAccountService::class)
        ),
        PasswordVerifyService::class => object()->constructor()
    ]
];