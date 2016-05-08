<?php
namespace Application\Account;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Account\Entity\Account;
use Application\Account\Entity\OAuthAccount;
use Application\Account\Repository\AccountRepository;
use Application\Account\Repository\OAuthAccountRepository;
use Application\Account\Service\AccountService;
use Application\Common\Factory\DoctrineRepositoryFactory;

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