<?php
use EmailVerification\Factory\Middleware\EmailVerificationMiddlewareFactory;
use EmailVerification\Factory\Repository\EmailVerificationRepositoryFactory;
use EmailVerification\Factory\Service\EmailVerificationServiceFactory;
use EmailVerification\Middleware\EmailVerificationMiddleware;
use EmailVerification\Repository\EmailVerificationRepository;
use EmailVerification\Service\EmailVerificationService;

return [
    'zend_service_manager' => [
        'factories' => [
            EmailVerificationRepository::class => EmailVerificationRepositoryFactory::class,
            EmailVerificationService::class => EmailVerificationServiceFactory::class,
            EmailVerificationMiddleware::class => EmailVerificationMiddlewareFactory::class,
        ]
    ]
];