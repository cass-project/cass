<?php
namespace Application\Auth;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Account\Repository\AccountRepository;
use Application\Account\Service\AccountService;
use Application\Auth\Middleware\AuthMiddleware;
use Application\Auth\Middleware\ProtectedMiddleware;
use Application\Auth\Service\AuthService;
use Application\Auth\Service\CurrentAccountService;
use Application\Frontline\Service\FrontlineService;

return [
    'php-di' => [
        AuthService::class => object()->constructor(
            get(AccountService::class),
            get(FrontlineService::class),
            get('oauth2_providers')
        ),
        AuthMiddleware::class => object()->constructor(
            get(AuthService::class),
            get(FrontlineService::class)
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