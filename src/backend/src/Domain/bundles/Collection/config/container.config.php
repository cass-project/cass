<?php
namespace Domain\Collection;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Middleware\CollectionMiddleware;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Collection\Service\CollectionService;
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