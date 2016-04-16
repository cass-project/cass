<?php
use Account\Repository\AccountRepository;
use Account\Repository\OAuthAccountRepository;
use Account\Service\AccountService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        AccountService::class => object()->constructor(
            get(AccountRepository::class),
            get(OAuthAccountRepository::class)
        ),
        AccountRepository::class => factory([EntityManager::class, 'getRepository']),
        OAuthAccountRepository::class => factory([RepositoryFactory::class, OAuthAccountRepository::class]),
    ],
];