<?php
namespace Domain\Collection;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Collection\Entity\Collection;
use Domain\Collection\Repository\CollectionRepository;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;

return [
    'php-di' => [
        CollectionRepository::class => factory(new DoctrineRepositoryFactory(Collection::class)),
    ]
];