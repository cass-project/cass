<?php
use Auth\Service\CurrentAccountService;
use Collection\Middleware\CollectionMiddleware;
use Collection\Repository\CollectionRepository;
use Collection\Service\CollectionService;
use Doctrine\ORM\EntityManager;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        CollectionRepository::class => factory([EntityManager::class, 'getRepository']),
        CollectionService::class => object()->constructor(
            get(CollectionRepository::class),
            get(CurrentAccountService::class)
        ),
        CollectionMiddleware::class => object()->constructor(
            CollectionService::class,
            CurrentAccountService::class
        )
    ]
];