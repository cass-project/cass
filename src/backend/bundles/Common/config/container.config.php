<?php
use Common\Bootstrap\Bundle\BundleService;
use Common\Service\SchemaService;
use Common\Service\TransactionService;

use Common\Factory\DoctrineEntityManagerFactory;
use Doctrine\ORM\EntityManager;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        SchemaService::class => object()->constructor(get(BundleService::class)),
        TransactionService::class => object()->constructor(get(EntityManager::class)),
        EntityManager::class => factory(DoctrineEntityManagerFactory::class)
    ]
];