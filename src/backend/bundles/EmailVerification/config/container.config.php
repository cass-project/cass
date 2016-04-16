<?php
use Auth\Service\CurrentAccountService;
use Doctrine\ORM\EntityManager;
use EmailVerification\Middleware\EmailVerificationMiddleware;
use EmailVerification\Repository\EmailVerificationRepository;
use EmailVerification\Service\EmailVerificationService;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        EmailVerificationRepository::class => factory([EntityManager::class, 'getRepository']),
        EmailVerificationService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(EmailVerificationRepository::class)
        ),
        EmailVerificationMiddleware::class => object()->constructor(
            get(EmailVerificationService::class)
        )
    ]
];