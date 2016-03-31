<?php
namespace Data;

use Data\Factory\DoctrineEntityManagerFactory;
use Data\Factory\Repository\AccountRepositoryFactory;
use Data\Factory\Repository\AttachmentRepositoryFactory;
use Data\Factory\Repository\HostRepositoryFactory;
use Data\Factory\Repository\OAuthAccountRepositoryFactory;
use Data\Factory\Repository\PostRepositoryFactory;
use Data\Factory\Repository\ThemeRepositoryFactory;
use Data\Factory\SphinxClientFactory;
use Data\Repository\AccountRepository;
use Data\Repository\Attachment\AttachmentRepository;
use Data\Repository\HostRepository;
use Data\Repository\OAuthAccountRepository;
use Data\Repository\Post\PostRepository;
use Data\Repository\Theme\ThemeRepository;
use Doctrine\ORM\EntityManager;
use Sphinx\SphinxClient;

return [
    'zend_service_manager' => [
        'factories' => [
            EntityManager::class => DoctrineEntityManagerFactory::class,
            AccountRepository::class => AccountRepositoryFactory::class,
            OAuthAccountRepository::class => OAuthAccountRepositoryFactory::class,
            ThemeRepository::class => ThemeRepositoryFactory::class,
            HostRepository::class => HostRepositoryFactory::class,
            PostRepository::class         => PostRepositoryFactory::class,
            AttachmentRepository::class   => AttachmentRepositoryFactory::class,
            SphinxClient::class => SphinxClientFactory::class
        ],
        'services' => [
            'DoctrineConfig' => require(__DIR__ . '/doctrine.config.php'),
            'SphinxConfig' => require(__DIR__ . '/sphinx.config.php'),
        ]
    ]
];