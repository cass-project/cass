<?php
namespace Domain\EmailVerification;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Auth\Service\CurrentAccountService;
use Application\Common\Factory\DoctrineRepositoryFactory;
use Domain\EmailVerification\Entity\EmailVerification;
use Domain\EmailVerification\Middleware\EmailVerificationMiddleware;
use Domain\EmailVerification\Repository\EmailVerificationRepository;
use Domain\EmailVerification\Service\EmailVerificationService;
use PhpAmqpLib\Connection\AMQPStreamConnection;

return [
    'php-di' => [
        EmailVerificationRepository::class => factory(new DoctrineRepositoryFactory(EmailVerification::class)),
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