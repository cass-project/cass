<?php
use Account\Entity\Account;
use Account\Entity\OAuthAccount;
use Account\Repository\AccountRepository;
use Account\Repository\OAuthAccountRepository;
use Account\Service\AccountService;
use Common\Factory\DoctrineRepositoryFactory;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        AccountService::class => object()->constructor(
            get(AccountRepository::class),
            get(OAuthAccountRepository::class)
        ),
        AccountRepository::class => factory(new DoctrineRepositoryFactory(Account::class)),
        OAuthAccountRepository::class => factory(new DoctrineRepositoryFactory(OAuthAccount::class)),
    ],
];