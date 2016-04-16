<?php
use Account\Factory\Repository\AccountRepositoryFactory;
use Account\Factory\Repository\OAuthAccountRepositoryFactory;
use Account\Factory\Service\AccountServiceFactory;
use Account\Repository\AccountRepository;
use Account\Repository\OAuthAccountRepository;
use Account\Service\AccountService;

return [
    'zend_service_manager' => [
        'factories' => [
            AccountService::class => AccountServiceFactory::class,
            AccountRepository::class => AccountRepositoryFactory::class,
            OAuthAccountRepository::class => OAuthAccountRepositoryFactory::class,
        ]
    ]
];