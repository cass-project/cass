<?php
namespace Application\EmailVerification;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Auth\Service\CurrentAccountService;
use Application\Common\Factory\DoctrineRepositoryFactory;
use Application\Common\Factory\AMQPStreamConnectionFactory;
use Application\EmailVerification\Entity\EmailVerification;
use Application\EmailVerification\Middleware\EmailVerificationMiddleware;
use Application\EmailVerification\Repository\EmailVerificationRepository;
use Application\EmailVerification\Service\EmailVerificationService;
use PhpAmqpLib\Connection\AMQPStreamConnection;

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