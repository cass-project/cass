<?php
namespace CASS\Domain\EmailVerification;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\EmailVerification\Entity\EmailVerification;
use CASS\Domain\EmailVerification\Repository\EmailVerificationRepository;

return [
    'php-di' => [
        EmailVerificationRepository::class => factory(new DoctrineRepositoryFactory(EmailVerification::class)),
    ]
];