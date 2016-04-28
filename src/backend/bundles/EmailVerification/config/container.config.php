<?php
use Auth\Service\CurrentAccountService;
use Common\Factory\DoctrineRepositoryFactory;
use Common\Factory\AMQPStreamConnectionFactory;
use EmailVerification\Entity\EmailVerification;
use EmailVerification\Middleware\EmailVerificationMiddleware;
use EmailVerification\Repository\EmailVerificationRepository;
use EmailVerification\Service\EmailVerificationService;
use PhpAmqpLib\Connection\AMQPStreamConnection;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        EmailVerificationRepository::class => factory(new DoctrineRepositoryFactory(EmailVerification::class)),
        AMQPStreamConnection::class => factory(AMQPStreamConnectionFactory::class),
        EmailVerificationService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(EmailVerificationRepository::class),
            get(AMQPStreamConnection::class)
        ),
        EmailVerificationMiddleware::class => object()->constructor(
            get(EmailVerificationService::class),
            get(CurrentAccountService::class)
        )
    ]
];