<?php
namespace Domain\Contact;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Contact\Entity\Contact;
use Domain\Contact\Repository\ContactRepository;

return [
    'php-di' => [
        ContactRepository::class => factory(new DoctrineRepositoryFactory(Contact::class)),
    ]
];