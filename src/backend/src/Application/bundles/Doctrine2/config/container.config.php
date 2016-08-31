<?php
namespace CASS\Application\Doctrine2;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineEntityManagerFactory;
use Doctrine\ORM\EntityManager;

return [
    'php-di' => [
        EntityManager::class => factory(DoctrineEntityManagerFactory::class)
    ]
];