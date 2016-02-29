<?php
namespace Data;

use Data\Factory\DoctrineEntityManagerFactory;
use Data\Factory\Repository\HostRepositoryFactory;
use Data\Factory\Repository\ThemeRepositoryFactory;
use Data\Repository\HostRepository;
use Data\Repository\Theme\ThemeRepository;
use Doctrine\ORM\EntityManager;

return [
    'zend_service_manager' => [
        'factories' => [
            EntityManager::class => DoctrineEntityManagerFactory::class,
            ThemeRepository::class => ThemeRepositoryFactory::class,
            HostRepository::class => HostRepositoryFactory::class,
        ],
        'services' => [
            'DoctrineConfig' => require(__DIR__ . '/doctrine.config.php'),
        ]
    ]
];