<?php
namespace Domain\EmailVerification;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\EmailVerification\Entity\EmailVerification;
use Domain\EmailVerification\Repository\EmailVerificationRepository;

return [
    'php-di' => [
        EmailVerificationRepository::class => factory(new DoctrineRepositoryFactory(EmailVerification::class)),
    ]
];