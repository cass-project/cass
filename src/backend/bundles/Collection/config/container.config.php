<?php
namespace Collection;

use Collection\Factory\Middleware\CollectionMiddlewareFactory;
use Collection\Factory\Repository\CollectionRepositoryFactory;
use Collection\Factory\Service\CollectionServiceFactory;
use Collection\Middleware\CollectionMiddleware;
use Collection\Repository\CollectionRepository;
use Collection\Service\CollectionService;

return [
    'zend_service_manager' => [
        'factories' => [
            CollectionService::class => CollectionServiceFactory::class,
            CollectionRepository::class => CollectionRepositoryFactory::class,
            CollectionMiddleware::class => CollectionMiddlewareFactory::class
        ]
    ]
];