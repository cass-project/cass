<?php
namespace Application\Collection;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Auth\Service\CurrentAccountService;
use Application\Collection\Entity\Collection;
use Application\Collection\Middleware\CollectionMiddleware;
use Application\Collection\Repository\CollectionRepository;
use Application\Collection\Service\CollectionService;
use Application\Common\Factory\DoctrineRepositoryFactory;

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