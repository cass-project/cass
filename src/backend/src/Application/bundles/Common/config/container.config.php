<?php
namespace Application\Common;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Common\Bootstrap\Bundle\BundleService;
use Application\Common\Service\SchemaService;
use Application\Common\Service\TransactionService;
use Application\Common\Factory\DoctrineEntityManagerFactory;
use Doctrine\ORM\EntityManager;

return [
    'php-di' => [
        SchemaService::class => object()->constructor(get(BundleService::class)),
        TransactionService::class => object()->constructor(get(EntityManager::class)),
        EntityManager::class => factory(DoctrineEntityManagerFactory::class)
    ]
];