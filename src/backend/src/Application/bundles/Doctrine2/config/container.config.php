<?php
namespace Application\Doctrine2;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Doctrine2\Service\TransactionService;
use Application\Doctrine2\Factory\DoctrineEntityManagerFactory;
use Doctrine\ORM\EntityManager;

return [
    'php-di' => [
        TransactionService::class => object()->constructor(get(EntityManager::class)),
        EntityManager::class => factory(DoctrineEntityManagerFactory::class)
    ]
];