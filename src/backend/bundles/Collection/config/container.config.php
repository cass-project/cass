<?php
use Auth\Service\CurrentAccountService;
use Collection\Entity\Collection;
use Collection\Middleware\CollectionMiddleware;
use Collection\Repository\CollectionRepository;
use Collection\Service\CollectionService;
use Common\Factory\DoctrineRepositoryFactory;
use Doctrine\ORM\EntityManager;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        CollectionRepository::class => factory(new DoctrineRepositoryFactory(Collection::class)),
        CollectionService::class => object()->constructor(
            get(CollectionRepository::class),
            get(CurrentAccountService::class)
        ),
        CollectionMiddleware::class => object()->constructor(
            get(CollectionService::class),
            get(CurrentAccountService::class)
        )
    ]
];