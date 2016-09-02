<?php
namespace CASS\Domain\Contact;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Contact\Entity\Contact;
use CASS\Domain\Contact\Repository\ContactRepository;

return [
    'php-di' => [
        ContactRepository::class => factory(new DoctrineRepositoryFactory(Contact::class)),
    ]
];