<?php
namespace Data;

use Data\Factory\DoctrineEntityManagerFactory;
use Data\Factory\Repository\AccountRepositoryFactory;
use Data\Factory\Repository\HostRepositoryFactory;
use Data\Factory\Repository\OAuthAccountRepositoryFactory;
use Data\Factory\Repository\PostRepositoryFactory;
use Data\Factory\Repository\ThemeRepositoryFactory;
use Data\Repository\AccountRepository;
use Data\Repository\HostRepository;
use Data\Repository\OAuthAccountRepository;
use Data\Repository\Post\PostRepository;
use Data\Repository\Theme\ThemeRepository;
use Doctrine\ORM\EntityManager;

return [
    'zend_service_manager' => [
        'factories' => [
            EntityManager::class => DoctrineEntityManagerFactory::class,
            AccountRepository::class => AccountRepositoryFactory::class,
            OAuthAccountRepository::class => OAuthAccountRepositoryFactory::class,
            ThemeRepository::class => ThemeRepositoryFactory::class,
            HostRepository::class => HostRepositoryFactory::class,
            PostRepository::class => PostRepositoryFactory::class
        ],
        'services' => [
            'DoctrineConfig' => require(__DIR__ . '/doctrine.config.php'),
        ]
    ]
];